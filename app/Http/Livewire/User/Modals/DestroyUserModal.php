<?php

namespace App\Http\Livewire\User\Modals;

use Livewire\Component;
use App\Models\User;

class DestroyUserModal extends Component
{
    protected $listeners = ['openDestroyUserModal'];

    public $modalDestroy = false;

    public $user=[];

    public function render()
    {
        return view('livewire.user.modals.destroy-user-modal');
    }

    public function openDestroyUserModal($id){
        $this->user['id']=$id;
        $this->modalDestroy=true;
    }

    public function destroy()
    {
        $user=User::find($this->user['id']);
        $user->delete();
        $this->emit('updateUserTable');
        $this->modalDestroy=false;
    }

    public function cancelar()
    {
        $this->limpiar();
    }

    public function limpiar(){
        $this->user=[];
        $this->modalDestroy=false;
    }
}
