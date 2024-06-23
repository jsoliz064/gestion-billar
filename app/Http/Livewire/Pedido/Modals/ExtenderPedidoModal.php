<?php

namespace App\Http\Livewire\Pedido\Modals;

use App\Models\Mesa;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Traits\ServerTrait;
use Carbon\Carbon;

class ExtenderPedidoModal extends Component
{
    use ServerTrait;
    protected $listeners = ['openExtenderPedidoModal'];

    public $modalExtender = false;
    public $pedido = [];
    public $mesa;
    public $error;

    public function render()
    {
        return view('livewire.pedido.modals.extender-pedido-modal');
    }

    public function openExtenderPedidoModal($mesaId)
    {
        $this->mesa = Mesa::find($mesaId);
        $pedido = $this->mesa->Pedido();
        $this->pedido = $pedido->toArray();
        $this->modalExtender = true;
    }

    public function extender()
    {
        $this->validate([
            'pedido.fecha_fin' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    if (strtotime($value) <= time()) {
                        $fail('La fecha y hora deben ser mayores que la fecha y hora actuales.');
                    }
                },
            ],
        ]);

        try {

            DB::transaction(function () {
                $pedido = $this->mesa->Pedido();
                $fecha_inicio = new Carbon($pedido->fecha_inicio);
                $fecha_fin = new Carbon($this->pedido['fecha_fin']);
                $diferencia_minutos = $fecha_inicio->diffInMinutes($fecha_fin);
                $cantidad_horas = round($diferencia_minutos / 60, 2);
                $total = $cantidad_horas * $this->mesa->precio;

                $pedido->update([
                    'fecha_fin' => $fecha_fin,
                    'cantidad_horas' => $cantidad_horas,
                    'total' => $total
                ]);

                $this->scheduleSwitch($this->mesa, 'off', $this->pedido['fecha_fin'], $pedido->id);
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
        $this->pedido = [];
        $this->mesa = null;
        $this->modalExtender = false;
        $this->error = null;
    }
}
