<?php

namespace App\Http\Livewire\User\Modals;

use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class CreateUserModal extends Component
{
    protected $listeners = ['openCreateUserModal'];

    public $modalCrear = false;

    public $user=[];
    public $email = null;

    public function render()
    {
        $rols=Role::all();
        return view('livewire.user.modals.create-user-modal', compact('rols'));
    }

    public function openCreateUserModal()
    {
        $this->modalCrear = true;
    }

    public function store()
    {
        $this->validate([
            'user.name'=>'required|string|max:255',
            'email'=>'required|string|max:255|email|unique:users',
            'user.password'=>'required|string|min:4',
            'user.rol_id'=>'required',
        ]);
        if ($this->user['password']!==$this->user['cpassword']){
            $this->validate([
                'user.password'=>'required|string|min:4|confirmed',
            ]);
        }
        $this->user['email']=$this->email;
        $this->user['password']=Hash::make($this->user['password']);
        $this->user['token']=Str::uuid();
        $user=User::create($this->user);
        $user->roles()->sync($this->user['rol_id']);
        $this->emit('updateUserTable');
        $this->limpiar();
    }

    public function cancelar()
    {
        $this->limpiar();
    }

    public function limpiar(){
        $this->user=[];
        $this->email=null;
        $this->modalCrear=false;
    }
}
