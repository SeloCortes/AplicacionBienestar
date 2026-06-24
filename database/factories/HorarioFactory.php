<?php

namespace Database\Factories;

use App\Models\Horario;
use App\Models\Curso;
use Illuminate\Database\Eloquent\Factories\Factory;

class HorarioFactory extends Factory
{
    protected $model = Horario::class;

    public function definition(): array
    {
        $hora_inicio = fake()->numberBetween(7, 18);
        $hora_fin = $hora_inicio + fake()->numberBetween(1, 2);

        return [
            'curso_id' => Curso::factory(),
            'dia' => fake()->randomElement(['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado']),
            'hora_inicio' => sprintf('%02d:00', $hora_inicio),
            'hora_fin' => sprintf('%02d:00', $hora_fin),
            'profesor' => fake()->name(),
            'salon' => 'Salón ' . fake()->numerify('###'),
            'codigo' => fake()->unique()->numerify('HOR-####'),
            'cupo_maximo_estudiante' => 25,
            'cupo_disponible_estudiante' => 25,
            'cupo_maximo_tercero' => 5,
            'cupo_disponible_tercero' => 5,
            'activo' => true,
        ];
    }
}
