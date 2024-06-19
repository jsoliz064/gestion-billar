<?php

namespace App\Http\Livewire\Oferta\Modals;

use App\Models\ProductoOferta;
use Livewire\Component;

class DestroyOfertaModal extends Component
{
    protected $listeners = ['openDestroyOfertaModal'];

    public $modalDestroy = false;

    public $oferta=[];

    public function render()
    {
        return view('livewire.oferta.modals.destroy-oferta-modal');
    }

    public function openDestroyOfertaModal($id){
        $this->oferta['id']=$id;
        $this->modalDestroy=true;
    }

    public function destroy()
    {
        $oferta=ProductoOferta::find($this->oferta['id']);
        $oferta->delete();
        $this->emit('updateOfertaTable');
        $this->modalDestroy=false;
    }

    public function cancelar()
    {
        $this->limpiar();
    }

    public function limpiar(){
        $this->oferta=[];
        $this->modalDestroy=false;
    }
}
