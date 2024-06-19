<?php

namespace App\Http\Livewire\User\RolModals;

use Livewire\Component;
use App\Models\Rol;
use Spatie\Permission\Models\Role;

class EditRolModal extends Component
{

    protected $listeners = ['openEditRolModal'];

    public $modalEdit = false;

    public $rol=[];

    public function render()
    {
        return view('livewire.user.rol-modals.edit-rol-modal');
    }

    public function openEditRolModal($id){
        $this->modalEdit=true;
        $this->rol=Role::find($id)->toArray();
    }

    public function update(){
        $this->validate([
            'rol.name'=>'required',
        ]);
        $rol=Role::find($this->rol['id']);
        $rol->name=$this->rol['name'];
        $rol->save();
        $this->emit('updateRolTable');
        $this->limpiar();
    }

    public function limpiar(){
        $this->rol=[];
        $this->modalEdit=false;
    }

    public function cancelar(){
        $this->limpiar();
    }
}
