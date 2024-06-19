<?php

namespace App\Http\Livewire\Permission;


use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Permission\Models\Permission;

class PermissionDatatable  extends DataTableComponent
{
    protected $model = Permission::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("ID", "id")
            ->searchable()
            ->sortable(),
            Column::make("Nombre", "name")
            ->searchable()
            ->sortable(),
        ];
    }

    public function builder(): Builder
    {
        return Permission::query();
    }

}

