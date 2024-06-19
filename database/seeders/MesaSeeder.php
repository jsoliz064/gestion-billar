<?php

namespace Database\Seeders;

use App\Models\Mesa;
use Illuminate\Database\Seeder;

class MesaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Mesa::create([
            'nombre' => "Mesa 1",
            'device_id' => "10017f4c2b",
            'host' => "192.168.0.102",
            'port' => "8081",
            'precio' => "10",
        ]);

        Mesa::create([
            'nombre' => "Mesa 2",
            'habilitado' => false
        ]);

        Mesa::create([
            'nombre' => "Mesa 3",
            'habilitado' => false
        ]);

        Mesa::create([
            'nombre' => "Mesa 4",
            'habilitado' => false
        ]);

        Mesa::create([
            'nombre' => "Mesa 5",
            'habilitado' => false
        ]);
    }
}
