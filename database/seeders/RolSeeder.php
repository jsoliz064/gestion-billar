<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role1 = Role::firstOrCreate(['name' => 'Admin']);
        $role2 = Role::firstOrCreate(['name' => 'Editor']);

        Permission::firstOrCreate(['name' => 'users.index'])->syncRoles([$role1, $role2]);
        Permission::firstOrCreate(['name' => 'users.create'])->syncRoles([$role1, $role2]);
        Permission::firstOrCreate(['name' => 'users.edit'])->syncRoles([$role1, $role2]);
        Permission::firstOrCreate(['name' => 'users.delete'])->syncRoles([$role1, $role2]);

        Permission::firstOrCreate(['name' => 'roles.index'])->syncRoles([$role1, $role2]);
        Permission::firstOrCreate(['name' => 'roles.create'])->syncRoles([$role1, $role2]);
        Permission::firstOrCreate(['name' => 'roles.edit'])->syncRoles([$role1, $role2]);
        Permission::firstOrCreate(['name' => 'roles.delete'])->syncRoles([$role1, $role2]);
        Permission::firstOrCreate(['name' => 'permissions.index'])->syncRoles([$role1, $role2]);

        Permission::firstOrCreate(['name' => 'mesas.index'])->syncRoles([$role1, $role2]);
        Permission::firstOrCreate(['name' => 'mesas.create'])->syncRoles([$role1, $role2]);
        Permission::firstOrCreate(['name' => 'mesas.edit'])->syncRoles([$role1, $role2]);
        Permission::firstOrCreate(['name' => 'mesas.delete'])->syncRoles([$role1, $role2]);

        Permission::firstOrCreate(['name' => 'pedidos.index'])->syncRoles([$role1, $role2]);
        Permission::firstOrCreate(['name' => 'pedidos.create'])->syncRoles([$role1, $role2]);
        Permission::firstOrCreate(['name' => 'pedidos.edit'])->syncRoles([$role1, $role2]);
        Permission::firstOrCreate(['name' => 'pedidos.delete'])->syncRoles([$role1, $role2]);
    }
}
