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
                'nombre' => 'Fútbol Sala Masculino',
                'tipo_curso' => 'Deporte formativo',
                'descripcion' => 'Entrenamiento intensivo de fútbol sala enfocado en técnica individual y táctica de equipo.',
                'imagen' => 'https://images.unsplash.com/photo-1574629810360-7efbbe195018?q=80&w=600&h=400&auto=format&fit=crop',
                'estado' => true,
            ],
            [
                'nombre' => 'Baloncesto Selección',
                'tipo_curso' => 'Deporte formativo',
                'descripcion' => 'Entrenamiento para el equipo representativo de baloncesto de la institución.',
                'imagen' => 'https://images.unsplash.com/photo-1546519638-68e109498ffc?q=80&w=600&h=400&auto=format&fit=crop',
                'estado' => true,
            ],
            [
                'nombre' => 'Voleibol Mixto',
                'tipo_curso' => 'Deporte formativo',
                'descripcion' => 'Práctica recreativa y formativa de voleibol para todos los niveles.',
                'imagen' => 'https://images.unsplash.com/photo-1592656670411-b1241f973e4e?q=80&w=600&h=400&auto=format&fit=crop',
                'estado' => true,
            ],
            [
                'nombre' => 'Danzas Folclóricas',
                'tipo_curso' => 'Arte y cultura',
                'descripcion' => 'Rescate y práctica de los ritmos tradicionales de nuestra región.',
                'imagen' => 'https://images.unsplash.com/photo-1508700115892-45ecd05ae2ad?q=80&w=600&h=400&auto=format&fit=crop',
                'estado' => true,
            ],
            [
                'nombre' => 'Teatro Contemporáneo',
                'tipo_curso' => 'Arte y cultura',
                'descripcion' => 'Exploración de nuevas tendencias teatrales y expresión corporal.',
                'imagen' => 'https://images.unsplash.com/photo-1507676184212-d03ab07a01bf?q=80&w=600&h=400&auto=format&fit=crop',
                'estado' => true,
            ],
            [
                'nombre' => 'Ensamble de Cuerdas',
                'tipo_curso' => 'Arte y cultura',
                'descripcion' => 'Práctica grupal para instrumentos de cuerda frotada y pulsada.',
                'imagen' => 'https://images.unsplash.com/photo-1510915361894-db8b60106cb1?q=80&w=600&h=400&auto=format&fit=crop',
                'estado' => true,
            ],
            [
                'nombre' => 'Yoga y Mindfulness',
                'tipo_curso' => 'Deporte formativo',
                'descripcion' => 'Espacio de conexión mente-cuerpo a través de asanas y meditación.',
                'imagen' => 'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?q=80&w=600&h=400&auto=format&fit=crop',
                'estado' => true,
            ],
            [
                'nombre' => 'Acondicionamiento Físico Funcional',
                'tipo_curso' => 'Deporte formativo',
                'descripcion' => 'Entrenamiento basado en movimientos naturales para mejorar la salud integral.',
                'imagen' => 'https://images.unsplash.com/photo-1517836357463-d25dfeac3438?q=80&w=600&h=400&auto=format&fit=crop',
                'estado' => true,
            ],
            [
                'nombre' => 'Fotografía Digital Estética',
                'tipo_curso' => 'Arte y cultura',
                'descripcion' => 'Taller de captura y edición fotográfica con enfoque artístico.',
                'imagen' => 'https://images.unsplash.com/photo-1452587925148-ce544e77e70d?q=80&w=600&h=400&auto=format&fit=crop',
                'estado' => true,
            ],
            [
                'nombre' => 'Identidad Institucional',
                'tipo_curso' => 'Catedra Santiaguina',
                'descripcion' => 'Módulo obligatorio sobre la historia, valores y misión de nuestra universidad.',
                'imagen' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=600&h=400&auto=format&fit=crop',
                'estado' => true,
            ],
        ];

        foreach ($cursos as $curso) {
            Curso::create($curso);
        }
    }
}
