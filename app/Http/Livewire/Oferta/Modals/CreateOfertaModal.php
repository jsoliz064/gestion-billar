<?php

namespace App\Http\Livewire\Oferta\Modals;

use App\Models\Producto;
use App\Models\ProductoOferta;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class CreateOfertaModal extends Component
{
    use WithFileUploads;
    protected $listeners = ['openCreateOfertaModal'];

    public $modalCrear = false;
    public $oferta = [];
    public $file;

    public function render()
    {
        $productos = Producto::all();
        return view('livewire.oferta.modals.create-oferta-modal', compact('productos'));
    }

    public function openCreateOfertaModal()
    {
        $this->modalCrear = true;
    }

    public function store()
    {
        $this->validate([
            'oferta.descripcion' => 'required|string|max:255',
            'oferta.precio' => 'required|numeric',
            'oferta.cantidad' => 'required|numeric',
            'oferta.producto_id' => 'required|numeric',
        ]);

        if ($this->file) {
            $imagenes = $this->file->store('img/ofertas', 'public');
            $image_path = Storage::url($imagenes);
            $this->oferta['imagen_path'] = $image_path;
        }

        ProductoOferta::create($this->oferta);
        $this->emit('updateOfertaTable');
        $this->limpiar();
    }

    public function cancelar()
    {
        $this->limpiar();
    }

    public function limpiar()
    {
        $this->oferta = [];
        $this->modalCrear = false;
    }
}
