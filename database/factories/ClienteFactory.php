<?php

namespace Database\Factories;

use App\Models\Cliente;
use App\Models\User;
use App\Models\Distribuidor;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClienteFactory extends Factory
{
    protected $model = Cliente::class;

    public function definition()
    {
        return [
            'razon' => $this->faker->company,
            'cuenta' => $this->faker->unique()->numberBetween(100000, 999999),
            'id_cliente' => $this->faker->unique()->numberBetween(100000000, 999999999),
            'representante' => $this->faker->name,
            'telefono' => $this->faker->numerify('##########'), // 10 dígitos
            'correo' => $this->faker->unique()->safeEmail,
            'fiscal' => $this->faker->address,
            'entrega' => $this->faker->address,
            'rfc' => $this->faker->regexify('[A-Z]{4}[0-9]{6}[A-Z0-9]{3}'),
            'ejecutivo' => Distribuidor::inRandomOrder()->first()->id ?? Distribuidor::factory(),
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
        ];
    }
}
