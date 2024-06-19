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
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable()
                ->searchable(),
            Column::make("Cliente")
                ->label(
                    function ($row, Column $column) {
                        $row->refresh();
                        $cliente = $row->Cliente;
                        return $cliente->nombre;
                    }
                )
                ->sortable()
                ->searchable(),
            Column::make("Telefono")
                ->label(
                    function ($row, Column $column) {
                        $row->refresh();
                        $cliente = $row->Cliente;
                        return $cliente->telefono;
                    }
                )
                ->sortable()
                ->searchable(),
            Column::make("Total Bs", "total")
                ->sortable()
                ->searchable(),
            Column::make("Fecha de pedido", "created_at")
                ->sortable()
                ->searchable(),
            Column::make("Fecha de entrega", "fecha_entrega")
                ->sortable()
                ->searchable(),
            Column::make("Estado", "estado")
                ->sortable()
                ->searchable(),
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
