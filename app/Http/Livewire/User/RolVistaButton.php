<?php

namespace App\Http\Livewire\User;

use Livewire\Component;

class RolVistaButton extends Component
{
    public $row=null;
    public function render()
    {
        return view('livewire.user.rol-vista-button');
    }
}
