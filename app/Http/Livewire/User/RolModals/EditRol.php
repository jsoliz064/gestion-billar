<?php

namespace App\Http\Livewire\User\RolModals;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class EditRol extends Component
{
    public $rol = [];
    public $rolId;
    public $selectedPermissions = [];

    public function mount($id)
    {
        $this->rolId = $id;
        $this->rol = Role::with('permissions')->findOrfail($this->rolId)->toArray();
        $this->selectedPermissions = array_column($this->rol['permissions'], 'id');
    }

    public function render()
    {
        $permissions = Permission::all();
        return view('livewire.user.rol-modals.edit-rol', compact('permissions'));
    }

    public function update()
    {
        $this->validate([
            'rol.name' => 'required',
        ]);
        $rol = Role::find($this->rol['id']);
        $rol->name = $this->rol['name'];
        $rol->save();

        $permissions = Permission::whereIn('id', $this->selectedPermissions)->get();
        $rol->syncPermissions($permissions);
        session()->flash('message', 'Rol actualizado exitosamente.');
        return redirect()->route('roles.index');
    }
}
