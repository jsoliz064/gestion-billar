<?php

namespace App\Http\Livewire\User\RolModals;


use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateRol extends Component
{
    public $rol = [];
    public $selectedPermissions = [];
    public function render()
    {
        $permissions = Permission::all();
        return view('livewire.user.rol-modals.create-rol', compact('permissions'));
    }

    public function store()
    {
        $this->validate([
            'rol.name' => 'required',
        ]);
        $this->rol['guard_name'] = "web";
        $rol = Role::create($this->rol);
        $permissions = Permission::whereIn('id', $this->selectedPermissions)->get();
        $rol->syncPermissions($permissions);
        session()->flash('message', 'Rol creado exitosamente');
        return redirect()->route('roles.index');
    }
}
