<?php

namespace App\Http\Livewire\Pedido\Modals;

use App\Models\Mesa;
use App\Models\Pedido;
use App\Traits\ServerTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class EditPedidoModal extends Component
{
    use ServerTrait;
    protected $listeners = ['openClosePedidoModal'];

    public $modalEdit = false;

    public $pedido;
    public $pedidoUpdate = [];
    public $email = null;
    public $mesa;
    public $error;

    public function render()
    {
        return view('livewire.pedido.modals.edit-pedido-modal');
    }

    public function openClosePedidoModal($mesaId)
    {
        $this->mesa = Mesa::find($mesaId);
        $this->pedido = $this->mesa->Pedido();
        if ($this->pedido->fecha_fin == null) {
            $fecha_inicio = new Carbon($this->pedido->fecha_inicio);
            $fecha_fin = new Carbon();
            $diferencia_minutos = $fecha_inicio->diffInMinutes($fecha_fin);
            $diferencia_horas = round($diferencia_minutos / 60, 2);
            $this->pedidoUpdate['fecha_fin'] =  $fecha_fin;
            $this->pedidoUpdate['cantidad_horas'] = $diferencia_horas;
        } else {
            $this->pedidoUpdate['fecha_fin'] =  $this->pedido->fecha_fin;
            $this->pedidoUpdate['cantidad_horas'] = $this->pedido->cantidad_horas;
        }
        $this->modalEdit = true;
    }

    public function terminarPedido()
    {
        try {
            $this->validate([
                'pedidoUpdate.fecha_fin' => 'required|date',
                'pedidoUpdate.cantidad_horas' => 'required|numeric|min:0',
            ]);

            DB::transaction(function () {
                $pedido = Pedido::find($this->pedido->id);
                if ($pedido->fecha_fin == null) {
                    $pedido->fecha_fin = new Carbon($this->pedidoUpdate['fecha_fin']);
                    $pedido->cantidad_horas = $this->pedidoUpdate['cantidad_horas'];
                }
                $pedido->estado = "terminado";
                $total = $pedido->cantidad_horas * $pedido->Mesa->precio;
                $pedido->total = $total;
                $pedido->save();
                $this->switch($this->mesa, "off");
            });

            $this->emit('updatePedidoTable');
            $this->limpiar();
        } catch (\Throwable $th) {
            $this->error = $th->getMessage();
        }
    }

    public function cancelar()
    {
        $this->limpiar();
    }

    public function limpiar()
    {
        $this->pedido = null;
        $this->mesa = null;
        $this->modalEdit = false;
        $this->pedidoUpdate = [];
        $this->error = null;
    }
}
