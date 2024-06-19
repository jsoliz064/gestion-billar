<?php

namespace App\Http\Livewire\Mesa;

use Livewire\Component;

class MesaLw extends Component
{
    public function render()
    {
        return view('livewire.mesa.mesa-lw');
    }

    public function openCreateMesaModal()
    {
        $this->emit('openCreateMesaModal');
    }
}
