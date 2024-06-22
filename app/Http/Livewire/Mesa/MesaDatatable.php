<?php

namespace App\Http\Livewire\Mesa;

use App\Models\Mesa;
use App\Traits\ServerTrait;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Illuminate\Database\Eloquent\Builder;

class MesaDatatable extends DataTableComponent
{
    use ServerTrait;

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

            Column::make("Habilitado")
                ->label(
                    function ($row, Column $column) {
                        $row->refresh();
                        if ($row->habilitado) {
                            return '<span class="text-success">Si</span>';
                        } else {
                            return '<span class="text-danger">No</span>';
                        }
                    }
                )
                ->html(),
            Column::make("On/Off")
                ->label(
                    function ($row, Column $column) {
                        $row->refresh();
                        if ($row->habilitado) {
                            return
                                "
                                <button class='btn btn-outline-success btn-sm' wire:click='on($row)'>Encender</button> 
                                <button class='btn btn-outline-secondary btn-sm' wire:click='off($row->id)'>Apagar</button>
                                ";
                        } else {
                            return '<span class="text-danger">Deshabilitado</span>';
                        }
                    }
                )
                ->html(),
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

    public function on(Mesa $mesa)
    {
        $this->switch($mesa, 'on');
    }

    public function off(Mesa $mesa)
    {
        $this->switch($mesa, 'off');
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
