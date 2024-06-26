<?php

namespace App\Http\Livewire\Pedido;

use App\Models\Mesa;
use Livewire\Component;

class PedidoLw extends Component
{
    protected $listeners = ['updatePedidoTable'];

    public $scheduleDatetime = [];

    public function render()
    {
        $mesas = Mesa::where('habilitado', true)->get();
        return view('livewire.pedido.pedido-lw', compact('mesas'));
    }

    public function createPedido($mesaId)
    {
        $this->emit('openCreatePedidoModal', $mesaId);
    }

    public function closePedido($mesaId)
    {
        $this->emit('openClosePedidoModal', $mesaId);
    }

    public function extenderPedido($mesaId)
    {
        $this->emit('openExtenderPedidoModal', $mesaId);
    }

    public function updatePedidoTable()
    {
        $this->render();
    }
}
