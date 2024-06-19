<?php

namespace App\Http\Livewire\Oferta\Modals;

use App\Models\Producto;
use App\Models\ProductoOferta;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

class EditOfertaModal extends Component
{
    use WithFileUploads;

    protected $listeners = ['openEditOfertaModal'];

    public $modalEdit = false;
    public $oferta = [];
    public $file;

    public function render()
    {
        $productos = Producto::all();
        return view('livewire.oferta.modals.edit-oferta-modal', compact('productos'));
    }

    public function openEditOfertaModal($id)
    {
        $this->oferta = ProductoOferta::find($id)->toArray();
        $this->modalEdit = true;
    }

    public function update()
    {
        $this->validate([
            'oferta.descripcion' => 'required|string|max:255',
            'oferta.precio' => 'required|numeric',
            'oferta.cantidad' => 'required|numeric',
            'oferta.producto_id' => 'required|numeric',
        ]);
        $oferta = ProductoOferta::find($this->oferta['id']);
        if ($this->file !== null) {
            if ($oferta->imagen_path) {
                $ruta = "../public" . $oferta->imagen_path;
                if (file_exists($ruta)) {
                    unlink($ruta);
                }
            }
            $imagen = $this->file->store('img/ofertas', 'public');
            $this->oferta['imagen_path'] = Storage::url($imagen);
        }
        $oferta->update($this->oferta);
        $this->emit('updateOfertaTable');
        $this->limpiar();
    }

    public function cancelar()
    {
        $this->limpiar();
    }

    public function limpiar()
    {
        $this->oferta = null;
        $this->modalEdit = false;
    }
}
