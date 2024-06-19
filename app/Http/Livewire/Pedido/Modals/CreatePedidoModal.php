<?php

namespace App\Http\Livewire\Pedido\Modals;

use App\Models\Mesa;
use App\Models\Pedido;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Traits\ServerTrait;
use Carbon\Carbon;

class CreatePedidoModal extends Component
{
    use ServerTrait;
    protected $listeners = ['openCreatePedidoModal'];

    public $modalCrear = false;
    public $pedido = [];
    public $mesa;

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
            'pedido.horas' => 'nullable|integer|min:1',
        ]);
        $this->pedido['fecha_inicio'] = now();
        $this->pedido['mesa_id'] = $this->mesa->id;

        if (isset($this->pedido['horas'])) {
            $fecha_inicio = Carbon::parse($this->pedido['fecha_inicio']);
            $horas = $this->pedido['horas'];
            $fecha_fin = $fecha_inicio->addHours($horas);
            $this->pedido['cantidad_horas'] = $horas;
            $this->pedido['fecha_fin'] = $fecha_fin;
        }

        $pedido = $this->pedido;
        $mesa = $this->mesa;
        DB::transaction(function () use ($pedido, $mesa) {
            Pedido::create($pedido);
            $this->switch($mesa, 'on');
            if (isset($pedido['fecha_fin'])) {
                $this->scheduleSwitch($mesa, 'off', $pedido['fecha_fin']);
            }
        });
        $this->emit('updatePedidoTable');
        $this->limpiar();
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
    }
}
