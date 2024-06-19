<?php

namespace App\Http\Livewire\User\RolModals;

use Livewire\Component;
use App\Models\Rol;
use App\Models\User;
use Spatie\Permission\Models\Role;

class DestroyRolModal extends Component
{
    protected $listeners = ['openDestroyRolModal'];

    public $modalDestroy = false;

    public $rol=[];

    public function render()
    {
        return view('livewire.user.rol-modals.destroy-rol-modal');
    }

    public function openDestroyRolModal($id){
        $this->rol['id']=$id;
        $this->modalDestroy=true;
    }

    public function destroy()
    {
        $rol=Role::find($this->rol['id']);
        $usersWithRole = User::whereHas('roles', function ($query) use ($rol) {
            $query->where('id', $rol->id);
        })->count();

        if ($usersWithRole > 0) {
           
            session()->flash('error', 'Error: No se puede eliminar un rol en uso');
            return;
        }
        $rol->delete();
        $this->emit('updateRolTable');
        $this->modalDestroy=false;
    }

    public function cancelar()
    {
        $this->limpiar();
    }

    public function limpiar(){
        $this->rol=[];
        $this->modalDestroy=false;
    }

}
