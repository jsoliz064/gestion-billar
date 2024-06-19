<?php

namespace App\Http\Livewire\User;

use Livewire\Component;

class UserLw extends Component
{

    public function render()
    {
        return view('livewire.user.user-lw');
    }
   
    public function openCreateUserModal()
    {
        $this->emit('openCreateUserModal');
    }
}
