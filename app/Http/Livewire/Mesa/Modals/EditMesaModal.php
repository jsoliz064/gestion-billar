<?php

namespace App\Http\Livewire\Mesa\Modals;

use App\Models\Mesa;
use Livewire\Component;

class EditMesaModal extends Component
{
    protected $listeners = ['openEditMesaModal'];

    public $modalEdit = false;
    public $mesa = [];

    public function render()
    {
        return view('livewire.mesa.modals.edit-mesa-modal');
    }

    public function openEditMesaModal($id)
    {
        $this->mesa = Mesa::find($id)->toArray();
        $this->modalEdit = true;
    }

    public function update()
    {
        $this->validate([
            'mesa.nombre' => 'required|string|max:255',
            'mesa.host' => 'nullable|string|max:255',
            'mesa.precio' => 'required|numeric',
            'mesa.habilitado' => 'nullable|boolean',
        ]);
        $mesa = Mesa::find($this->mesa['id']);
        $mesa->update($this->mesa);
        $this->emit('updateMesaTable');
        $this->limpiar();
    }

    public function cancelar()
    {
        $this->limpiar();
    }

    public function limpiar()
    {
        $this->mesa = null;
        $this->modalEdit = false;
    }
}
