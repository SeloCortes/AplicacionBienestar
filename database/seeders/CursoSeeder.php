<?php

namespace Database\Seeders;

use App\Models\Curso;
use Illuminate\Database\Seeder;

class CursoSeeder extends Seeder
{
    public function run(): void
    {
        $cursos = [
            [
                'nombre' => 'Fútbol',
                'tipo_curso' => 'Deporte formativo',
                'descripcion' => 'Entrenamiento de fútbol enfocado en técnica, trabajo en equipo y condición física.',
                'imagen' => 'https://placehold.co/600x400?text=Futbol',
                'estado' => true,
            ],
            [
                'nombre' => 'Baloncesto',
                'tipo_curso' => 'Deporte formativo',
                'descripcion' => 'Curso de baloncesto para desarrollar habilidades técnicas y tácticas.',
                'imagen' => 'https://placehold.co/600x400?text=Baloncesto',
                'estado' => true,
            ],
            [
                'nombre' => 'Voleibol',
                'tipo_curso' => 'Deporte formativo',
                'descripcion' => 'Formación en fundamentos técnicos y estrategias del voleibol.',
                'imagen' => 'https://placehold.co/600x400?text=Voleibol',
                'estado' => true,
            ],
            [
                'nombre' => 'Danza Urbana',
                'tipo_curso' => 'Arte y cultura',
                'descripcion' => 'Espacio para aprender coreografías y estilos de danza urbana.',
                'imagen' => 'https://placehold.co/600x400?text=Danza+Urbana',
                'estado' => true,
            ],
            [
                'nombre' => 'Teatro',
                'tipo_curso' => 'Arte y cultura',
                'descripcion' => 'Taller de expresión corporal, actuación y desarrollo escénico.',
                'imagen' => 'https://placehold.co/600x400?text=Teatro',
                'estado' => true,
            ],
            [
                'nombre' => 'Guitarra',
                'tipo_curso' => 'Arte y cultura',
                'descripcion' => 'Curso básico de guitarra para estudiantes interesados en la música.',
                'imagen' => 'https://placehold.co/600x400?text=Guitarra',
                'estado' => true,
            ],
            [
                'nombre' => 'Yoga',
                'tipo_curso' => 'Deporte formativo',
                'descripcion' => 'Sesiones de yoga para mejorar la flexibilidad, respiración y bienestar mental.',
                'imagen' => 'https://placehold.co/600x400?text=Yoga',
                'estado' => true,
            ],
            [
                'nombre' => 'Acondicionamiento Físico',
                'tipo_curso' => 'Deporte formativo',
                'descripcion' => 'Entrenamiento físico general para mejorar la resistencia y salud.',
                'imagen' => 'https://placehold.co/600x400?text=Acondicionamiento+Fisico',
                'estado' => true,
            ],
            [
                'nombre' => 'Fotografía',
                'tipo_curso' => 'Arte y cultura',
                'descripcion' => 'Introducción a la fotografía, manejo de cámara y composición.',
                'imagen' => 'https://placehold.co/600x400?text=Fotografia',
                'estado' => true,
            ],
            [
                'nombre' => 'Pintura y Expresión Artística',
                'tipo_curso' => 'Arte y cultura',
                'descripcion' => 'Espacio creativo para explorar técnicas básicas de pintura.',
                'imagen' => 'https://placehold.co/600x400?text=Pintura',
                'estado' => true,
            ],
        ];

        foreach ($cursos as $curso) {
            Curso::create($curso);
        }
    }
}
