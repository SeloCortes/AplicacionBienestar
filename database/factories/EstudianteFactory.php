<?php

namespace Database\Factories;

use App\Models\Estudiante;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EstudianteFactory extends Factory
{
    protected $model = Estudiante::class;

    public function definition(): array
    {
        return [
            'usuario_id' => User::factory(),
            'facultad' => fake()->randomElement(['Ingeniería', 'Ciencias de la Salud', 'Derecho', 'Ciencias Económicas', 'Educación', 'Ciencias Básicas']),
            'nombre_carrera' => fake()->randomElement(['Ingeniería de Sistemas', 'Medicina', 'Derecho', 'Administración de Empresas', 'Licenciatura en Idiomas', 'Biología', 'Arquitectura', 'Contaduría']),
            'semestre' => fake()->numberBetween(1, 10),
        ];
    }
}
