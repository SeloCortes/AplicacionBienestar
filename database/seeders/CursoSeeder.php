<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Curso;
use App\Models\Horario;

class CursoSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Cátedra Santiaguina
        $catedra = Curso::factory()->create([
            'nombre' => 'Cátedra Santiaguina',
            'tipo_curso' => 'Catedra Santiaguina',
        ]);

        Horario::factory()->create([
            'curso_id' => $catedra->id,
            'cupo_maximo_estudiante' => 500,
            'cupo_disponible_estudiante' => 500,
            'cupo_maximo_tercero' => 0,
            'cupo_disponible_tercero' => 0,
        ]);

        // 2. Deporte Formativo (20 cursos, 5 horarios c/u)
        $deporteCursos = Curso::factory()->count(20)->create([
            'tipo_curso' => 'Deporte formativo',
        ]);

        foreach ($deporteCursos as $curso) {
            Horario::factory()->count(5)->create([
                'curso_id' => $curso->id,
                'cupo_maximo_estudiante' => 25,
                'cupo_disponible_estudiante' => 25,
                'cupo_maximo_tercero' => 5,
                'cupo_disponible_tercero' => 5,
            ]);
        }

        // 3. Arte y Cultura (20 cursos, 5 horarios c/u)
        $arteCursos = Curso::factory()->count(20)->create([
            'tipo_curso' => 'Arte y cultura',
        ]);

        foreach ($arteCursos as $curso) {
            Horario::factory()->count(5)->create([
                'curso_id' => $curso->id,
                'cupo_maximo_estudiante' => 25,
                'cupo_disponible_estudiante' => 25,
                'cupo_maximo_tercero' => 5,
                'cupo_disponible_tercero' => 5,
            ]);
        }
    }
}
