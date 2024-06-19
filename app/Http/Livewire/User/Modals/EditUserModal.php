<?php

namespace App\Http\Livewire\User\Modals;

use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Livewire\WithPagination;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;


class EditUserModal extends Component
{
    protected $listeners = ['openEditUserModal'];

    public $modalEdit = false;

    public $user=[];
    public $email = null;

    public function render()
    {
        $rols=Role::all();
        return view('livewire.user.modals.edit-user-modal', compact('rols'));
    }

    public function openEditUserModal($id){
        $this->modalEdit=true;
        $user=User::find($id);
        $this->user=User::find($id)->toArray();
        $this->email=$this->user['email'];
        $this->user['password']="";
        $this->user['cpassword']="";
        $this->user['rol_id']=$user->rol_id();
    }

    public function update(){
        $this->validate([
            'user.name'=>'required|string|max:255',
            'user.rol_id'=>'required',
        ]);
        $user=User::find($this->user['id']);

        if ($this->email!==$user->email){
            $this->validate([
                'email'=>'required|string|max:255|email|unique:users',
            ]);
        }

        if ($this->user['password']){
            if ($this->user['password']!==$this->user['cpassword']){
                $this->validate([
                    'user.password'=>'required|string|min:4|confirmed',
                ]);
            }
            $this->user['password']=Hash::make($this->user['password']);
            $user->password=$this->user['password'];
        }
        $this->user['email']=$this->email;

        $user->name=$this->user['name'];
        $user->email=$this->user['email'];
        $user->roles()->sync($this->user['rol_id']);
        $user->save();
        $this->emit('updateUserTable');
        $this->limpiar();
    }

    public function cancelar()
    {
        $this->limpiar();
    }

    public function limpiar(){
        $this->user=null;
        $this->email=null;
        $this->modalEdit=false;
    }
}
