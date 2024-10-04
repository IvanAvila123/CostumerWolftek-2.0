<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cliente;
use App\Models\Linea;
use App\Models\User;
use App\Models\Distribuidor;

class LargeDataSeeder extends Seeder
{
    public function run()
    {
        // Asegúrate de tener al menos un usuario y un distribuidor
        User::factory()->count(5)->create();
        Distribuidor::factory()->count(3)->create();

        // Crear 10,000 clientes con líneas
        Cliente::factory()
            ->count(10000)
            ->create()
            ->each(function ($cliente) {
                Linea::factory()->count(rand(1, 5))->create([
                    'cliente_id' => $cliente->id,
                ]);
            });
    }
}
