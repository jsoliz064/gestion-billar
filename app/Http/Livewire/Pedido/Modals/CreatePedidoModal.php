<?php

namespace App\Http\Livewire\Pedido\Modals;

use App\Models\Mesa;
use App\Models\Pedido;
use App\Traits\AroundTrait;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Traits\ServerTrait;
use Carbon\Carbon;

class CreatePedidoModal extends Component
{
    use ServerTrait, AroundTrait;
    protected $listeners = ['openCreatePedidoModal'];

    public $modalCrear = false;
    public $pedido = [];
    public $mesa;
    public $error;

    public function render()
    {
        return view('livewire.pedido.modals.create-pedido-modal');
    }

    public function openCreatePedidoModal($mesaId)
    {
        $this->mesa = Mesa::find($mesaId);
        $this->modalCrear = true;
    }

    public function store()
    {
        $this->validate([
            'pedido.cantidad_horas' => 'nullable|integer|min:1',
            'pedido.fecha_fin' => [
                'nullable',
                'date',
                function ($attribute, $value, $fail) {
                    if (strtotime($value) <= time()) {
                        $fail('La fecha y hora deben ser mayores que la fecha y hora actuales.');
                    }
                },
            ],
        ]);

        try {
            $this->pedido['fecha_inicio'] = Carbon::now();
            $this->pedido['mesa_id'] = $this->mesa->id;

            $cantidad_horas = isset($this->pedido['cantidad_horas']) && $this->pedido['cantidad_horas'] !== '';

            if ($cantidad_horas) {
                $fecha_inicio = $this->pedido['fecha_inicio'];
                $horas = $this->pedido['cantidad_horas'];
                $fecha_fin = $fecha_inicio->addHours($horas);
                $this->pedido['fecha_fin'] = $fecha_fin->format('Y-m-d\TH:i');
            }

            if (!$cantidad_horas && isset($this->pedido['fecha_fin'])) {
                $fecha_inicio = new Carbon($this->pedido['fecha_inicio']);
                $fecha_fin = new Carbon($this->pedido['fecha_fin']);
                $diferencia_minutos = $fecha_inicio->diffInMinutes($fecha_fin);
                $diferencia_horas = round($diferencia_minutos / 60, 2);
                $this->pedido['cantidad_horas'] = $diferencia_horas;
            }

            DB::transaction(function () {
                $pedidoDb = Pedido::create($this->pedido);
                $this->switch($this->mesa, 'on');
                if (isset($this->pedido['fecha_fin'])) {
                    $this->scheduleSwitch($this->mesa, 'off', $this->pedido['fecha_fin'], $pedidoDb->id);
                }
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
        $this->modalCrear = false;
        $this->error = null;
    }
}
