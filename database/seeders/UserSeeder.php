<?php

namespace Database\Seeders;
use App\Models\User;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user1 = User::create([
            'name'=> 'Administrador',
            'email'=> 'admin@gmail.com',
            'password' => bcrypt('1234'),
        ])->assignRole('Admin');
    }
}
