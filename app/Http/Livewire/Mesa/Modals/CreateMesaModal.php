<?php

namespace App\Http\Livewire\Mesa\Modals;

use App\Models\Mesa;
use Livewire\Component;

class CreateMesaModal extends Component
{
    protected $listeners = ['openCreateMesaModal'];

    public $modalCrear = false;
    public $mesa = [];

    public function render()
    {
        return view('livewire.mesa.modals.create-mesa-modal');
    }

    public function openCreateMesaModal()
    {
        $this->modalCrear = true;
    }

    public function store()
    {
        $this->validate([
            'mesa.nombre' => 'required|string|max:255',
            'mesa.host' => 'nullable|string|max:255',
            'mesa.precio' => 'required|number',
            'mesa.habilitado' => 'nullable|boolean',
        ]);

        Mesa::create($this->mesa);

        $this->emit('updateMesaTable');
        $this->limpiar();
    }

    public function cancelar()
    {
        $this->limpiar();
    }

    public function limpiar()
    {
        $this->mesa = [];
        $this->modalCrear = false;
    }
}
