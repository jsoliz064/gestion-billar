<?php

namespace App\Http\Livewire\Oferta;

use Livewire\Component;

class OfertaLw extends Component
{
    public function render()
    {
        return view('livewire.oferta.oferta-lw');
    }

    public function openCreateOfertaModal()
    {
        $this->emit('openCreateOfertaModal');
    }
}
