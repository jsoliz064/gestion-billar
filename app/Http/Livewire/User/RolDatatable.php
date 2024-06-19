<?php

namespace App\Http\Livewire\User;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class RolDatatable extends DataTableComponent
{
    protected $listeners = ['updateRolTable'];
    protected $model = Role::class;

    public function hasPermissions($permissions)
    {
        $user = User::find(Auth::id());
        return $user->hasPermissionTo($permissions);
    }

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
            Column::make("Nombre del rol", "name")
                ->sortable() 
                ->searchable(),
                Column::make('Acciones', 'id')
                ->format(function ($value, $row, Column $column) {
                    return view('livewire.user.rol-vista-button', [
                        'row' => $row
                    ]);
                }),
        ];
    }

    public function builder(): Builder
    {
        return Role::query();
    }

    public function destroy($rolId)
    {
        $this->emit('openDestroyRolModal', $rolId);
    }

    public function updateRolTable()
    {
        $this->builder();
    }
}
