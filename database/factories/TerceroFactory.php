<?php

namespace Database\Factories;

use App\Models\Tercero;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TerceroFactory extends Factory
{
    protected $model = Tercero::class;

    public function definition(): array
    {
        return [
            'usuario_id' => User::factory(),
            'estamento' => fake()->randomElement(['Egresado', 'Empleado', 'Pensionado', 'Familiar']),
        ];
    }
}
