<?php

namespace Database\Factories;

use App\Models\Curso;
use Illuminate\Database\Eloquent\Factories\Factory;

class CursoFactory extends Factory
{
    protected $model = Curso::class;

    public function definition(): array
    {
        return [
            'codigo' => fake()->unique()->numerify('CUR-####'),
            'nombre' => fake()->words(3, true),
            'tipo_curso' => fake()->randomElement(['Deporte formativo', 'Arte y cultura']),
            'descripcion' => fake()->paragraph(),
            'imagen' => null,
            'activo' => true,
        ];
    }
}
