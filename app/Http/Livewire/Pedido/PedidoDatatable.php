<?php

namespace App\Http\Livewire\Pedido;

use App\Models\Pedido;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Illuminate\Database\Eloquent\Builder;

class PedidoDatatable extends DataTableComponent
{
    protected $listeners = ['updatePedidoTable'];
    protected $model = Pedido::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id')->setDefaultSort('id', 'desc');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable()
                ->searchable(),
            Column::make("Mesa")
                ->label(
                    function ($row, Column $column) {
                        $row->refresh();
                        $mesa = $row->Mesa;
                        return $mesa->nombre;
                    }
                )
                ->sortable()
                ->searchable(),
            Column::make("Fecha de Inicio", "fecha_inicio")
                ->sortable()
                ->searchable(),
            Column::make("Fecha de Fin", "fecha_fin")
                ->sortable()
                ->searchable(),
            Column::make("Cantidad de Hrs", "cantidad_horas")
                ->sortable()
                ->searchable(),
            Column::make("Total Bs", "total")
                ->sortable()
                ->searchable(),
            Column::make("Estado")
                ->label(
                    function ($row, Column $column) {
                        $row->refresh();
                        $estado = $row->estado;
                        if ($estado == 'terminado') {
                            return '<span class="text-success">Terminado</span>';
                        } else {
                            return '<span class="text-warning">Pendiente</span>';
                        }
                    }
                )
                ->html(),
            Column::make('Acciones', 'id')
                ->format(function ($value, $row, Column $column) {
                    return view('livewire.pedido.pedido-vista-button', [
                        'row' => $row
                    ]);
                }),
        ];
    }

    public function builder(): Builder
    {
        return Pedido::query();
    }

    public function edit($pedidoId)
    {
        $this->emit('openEditPedidoModal', $pedidoId);
    }

    public function destroy($pedidoId)
    {
        $this->emit('openDestroyPedidoModal', $pedidoId);
    }

    public function updatePedidoTable()
    {
        $this->builder();
    }
}
