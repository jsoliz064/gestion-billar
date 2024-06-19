<?php

namespace App\Http\Livewire\Pedido\Modals;

use App\Models\Pedido;
use Livewire\Component;

class DestroyPedidoModal extends Component
{
    protected $listeners = ['openDestroyPedidoModal'];

    public $modalDestroy = false;

    public $pedido=[];

    public function render()
    {
        return view('livewire.pedido.modals.destroy-pedido-modal');
    }

    public function openDestroyPedidoModal($id){
        $this->pedido['id']=$id;
        $this->modalDestroy=true;
    }

    public function destroy()
    {
        $pedido=Pedido::find($this->pedido['id']);
        $pedido->delete();
        $this->emit('updatePedidoTable');
        $this->modalDestroy=false;
    }

    public function cancelar()
    {
        $this->limpiar();
    }

    public function limpiar(){
        $this->pedido=[];
        $this->modalDestroy=false;
    }
}
