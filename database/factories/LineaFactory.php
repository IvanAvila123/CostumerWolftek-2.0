<?php

namespace Database\Factories;

use App\Models\Linea;
use App\Models\Cliente;
use App\Models\User;
use App\Models\Distribuidor;
use Illuminate\Database\Eloquent\Factories\Factory;

class LineaFactory extends Factory
{
    protected $model = Linea::class;

    public function definition()
    {
        return [
            'dn' => $this->faker->unique()->numerify('##########'),
            'fecha' => $this->faker->dateTimeBetween('-1 year', '+1 year'),
            'plan' => $this->faker->randomElement(['Plan Básico', 'Plan Intermedio', 'Plan Premium']),
            'equipo' => $this->faker->randomElement(['iPhone 12', 'Samsung Galaxy S21', 'Google Pixel 5']),
            'cliente_id' => Cliente::factory(),
            'user_id' => User::factory(),
            'id_distribuidor' => Distribuidor::inRandomOrder()->first()->id ?? Distribuidor::factory(),
            'order' => $this->faker->numberBetween(1, 1000),
        ];
    }
}
