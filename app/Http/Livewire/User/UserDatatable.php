<?php

namespace App\Http\Livewire\User;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class UserDatatable extends DataTableComponent
{
    protected $listeners = ['updateUserTable'];
    protected $model = User::class;

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
            Column::make("Nombre", "name")
                ->sortable()
                ->searchable(),
            Column::make("Email", "email")
                ->sortable()
                ->searchable(),
            Column::make("Rol")
                ->label(
                    fn ($row, Column $column) => (User::find($row->id))->rol_name()
                )
                ->sortable()
                ->searchable(),
            Column::make('Acciones', 'id')
                ->format(function ($value, $row, Column $column) {
                    return view('livewire.user.user-vista-button', [
                        'row' => $row
                    ]);
                }),
        ];
    }

    public function builder(): Builder
    {
        return User::query();
    }

    public function edit($userId)
    {
        $this->emit('openEditUserModal', $userId);
    }

    public function destroy($userId)
    {
        $this->emit('openDestroyUserModal', $userId);
    }

    public function updateUserTable()
    {
        $this->builder();
    }
}
