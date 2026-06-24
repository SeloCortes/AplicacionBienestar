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
            'descripcion' => 'Curso institucional obligatorio sobre los valores, historia y principios de la universidad.',
        ]);

        Horario::factory()->create([
            'curso_id' => $catedra->id,
            'cupo_maximo_estudiante' => 500,
            'cupo_disponible_estudiante' => 500,
            'cupo_maximo_tercero' => 0,
            'cupo_disponible_tercero' => 0,
        ]);

        // 2. Deporte Formativo (20 cursos, 5 horarios c/u)
        $nombresDeportes = [
            'Fútbol Sala', 'Baloncesto', 'Voleibol', 'Natación Básica', 'Tenis de Mesa',
            'Ajedrez', 'Atletismo', 'Taekwondo', 'Karate Do', 'Judo',
            'Gimnasia Básica', 'Levantamiento de Pesas', 'Tenis de Campo', 'Patinaje', 'Ciclismo Recreativo',
            'Béisbol', 'Softbol', 'Rugby', 'Ultimate Frisbee', 'Acondicionamiento Físico'
        ];

        foreach ($nombresDeportes as $nombre) {
            $curso = Curso::factory()->create([
                'nombre' => $nombre,
                'tipo_curso' => 'Deporte formativo',
                'descripcion' => 'Curso práctico de ' . $nombre . ' enfocado en el desarrollo de habilidades motrices y trabajo en equipo.',
            ]);

            Horario::factory()->count(5)->create([
                'curso_id' => $curso->id,
                'cupo_maximo_estudiante' => 25,
                'cupo_disponible_estudiante' => 25,
                'cupo_maximo_tercero' => 5,
                'cupo_disponible_tercero' => 5,
            ]);
        }

        // 3. Arte y Cultura (20 cursos, 5 horarios c/u)
        $nombresArtes = [
            'Guitarra Acústica', 'Técnica Vocal', 'Danza Contemporánea', 'Bailes Latinos', 'Teatro y Actuación',
            'Pintura al Óleo', 'Dibujo Artístico', 'Fotografía Básica', 'Apreciación Cinematográfica', 'Creación Literaria',
            'Danza Folclórica', 'Percusión Latina', 'Piano Básico', 'Escultura en Arcilla', 'Ilustración Digital',
            'Producción Musical', 'Expresión Corporal', 'Coro Universitario', 'Oratoria y Liderazgo', 'Historia del Arte'
        ];

        foreach ($nombresArtes as $nombre) {
            $curso = Curso::factory()->create([
                'nombre' => $nombre,
                'tipo_curso' => 'Arte y cultura',
                'descripcion' => 'Taller de ' . $nombre . ' para potenciar la sensibilidad artística y la creatividad.',
            ]);

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
