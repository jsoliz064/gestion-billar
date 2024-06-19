<?php

namespace App\Http\Livewire\Oferta;

use App\Models\ProductoOferta;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Illuminate\Database\Eloquent\Builder;

class OfertaDatatable extends DataTableComponent
{
    protected $listeners = ['updateOfertaTable'];
    protected $model = ProductoOferta::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable()
                ->searchable(),
            Column::make("Producto")
                ->label(
                    function ($row, Column $column) {
                        $row->refresh();
                        $producto = $row->Producto;
                        return $producto->nombre;
                    }
                )
                ->sortable()
                ->searchable(),
            Column::make("Descripcion", "descripcion")
                ->sortable()
                ->searchable(),
            Column::make("Precio", "precio")
                ->sortable()
                ->searchable(),
            Column::make("Cantidad", "cantidad")
                ->sortable()
                ->searchable(),
            Column::make('Acciones', 'id')
                ->format(function ($value, $row, Column $column) {
                    return view('livewire.oferta.oferta-vista-button', [
                        'row' => $row
                    ]);
                }),
        ];
    }

    public function builder(): Builder
    {
        return ProductoOferta::query();
    }

    public function edit($ofertaId)
    {
        $this->emit('openEditOfertaModal', $ofertaId);
    }

    public function sendOffer($ofertaId)
    {
        $this->emit('openEnviarOfertaModal', $ofertaId);
    }

    public function destroy($ofertaId)
    {
        $this->emit('openDestroyOfertaModal', $ofertaId);
    }

    public function updateOfertaTable()
    {
        $this->builder();
    }
}
