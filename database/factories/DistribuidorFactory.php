<?php

namespace Database\Factories;

use App\Models\Cliente;
use App\Models\User;
use App\Models\Distribuidor;
use Illuminate\Database\Eloquent\Factories\Factory;

class DistribuidorFactory extends Factory
{
    protected $model = Distribuidor::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->firstName,
            'apellido' => $this->faker->lastName,
            'correo' => $this->faker->unique()->safeEmail,
            'telefono' => $this->faker->phoneNumber,
            'user_id' => User::factory(),
        ];
    }

}
