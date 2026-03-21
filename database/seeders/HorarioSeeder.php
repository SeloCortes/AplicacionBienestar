<?php

namespace Database\Seeders;

use App\Models\Curso;
use App\Models\Horario;
use Illuminate\Database\Seeder;

class HorarioSeeder extends Seeder
{
    public function run(): void
    {
        $cursos = Curso::all();

        $dias = ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'];
        $profesores = [
            'Dr. Roberto Gomez',
            'Lic. Sandra Lopez',
            'Mag. Carlos Enrique',
            'Dra. Martha Lucia',
            'Prof. Andres Felipe',
            'Ing. Claudia Jimenez',
        ];

        foreach ($cursos as $curso) {
            // Cada curso tendrá entre 1 y 3 horarios
            $numHorarios = rand(1, 3);
            
            for ($i = 0; $i < $numHorarios; $i++) {
                $horaInicio = rand(7, 18);
                $horaFin = $horaInicio + 2;

                Horario::create([
                    'curso_id' => $curso->id,
                    'dia' => $dias[array_rand($dias)],
                    'hora_inicio' => sprintf('%02d:00:00', $horaInicio),
                    'hora_fin' => sprintf('%02d:00:00', $horaFin),
                    'profesor' => $profesores[array_rand($profesores)],
                    'cupo_maximo' => 30,
                    'cupo_disponible' => 30,
                    'estado' => true,
                ]);
            }
        }
    }
}
