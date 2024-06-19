<?php

namespace App\Http\Livewire\Mesa;

use App\Models\Mesa;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Illuminate\Database\Eloquent\Builder;

class MesaDatatable extends DataTableComponent
{
    protected $listeners = ['updateMesaTable'];
    protected $model = Mesa::class;

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
            Column::make("Nombres", "nombre")
                ->sortable()
                ->searchable(),
            Column::make("Device ID", "device_id")
                ->sortable()
                ->searchable(),
            Column::make("Host", "host")
                ->sortable()
                ->searchable(),
            Column::make("Port", "port")
                ->sortable()
                ->searchable(),
            Column::make("Precio", "precio")
                ->sortable()
                ->searchable(),
            Column::make("Habilitado", "habilitado")
                ->sortable()
                ->searchable(),
            Column::make('Acciones', 'id')
                ->format(function ($value, $row, Column $column) {
                    return view('livewire.mesa.mesa-vista-button', [
                        'row' => $row
                    ]);
                }),
        ];
    }

    public function builder(): Builder
    {
        return Mesa::query();
    }

    public function edit($mesaId)
    {
        $this->emit('openEditMesaModal', $mesaId);
    }

    public function destroy($mesaId)
    {
        $this->emit('openDestroyMesaModal', $mesaId);
    }

    public function updateMesaTable()
    {
        $this->builder();
    }
}
