<?php

namespace App\Http\Livewire\Mesa\Modals;

use App\Models\Mesa;
use Livewire\Component;

class DestroyMesaModal extends Component
{
    protected $listeners = ['openDestroyMesaModal'];

    public $modalDestroy = false;

    public $mesa=[];

    public function render()
    {
        return view('livewire.mesa.modals.destroy-mesa-modal');
    }

    public function openDestroyMesaModal($id){
        $this->mesa['id']=$id;
        $this->modalDestroy=true;
    }

    public function destroy()
    {
        $mesa=Mesa::find($this->mesa['id']);
        $mesa->delete();
        $this->emit('updateMesaTable');
        $this->modalDestroy=false;
    }

    public function cancelar()
    {
        $this->limpiar();
    }

    public function limpiar(){
        $this->mesa=[];
        $this->modalDestroy=false;
    }
}
