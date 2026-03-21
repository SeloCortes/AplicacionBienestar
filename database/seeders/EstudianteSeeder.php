<?php

namespace Database\Seeders;

use App\Models\Estudiante;
use App\Models\User;
use Illuminate\Database\Seeder;

class EstudianteSeeder extends Seeder
{
    public function run()
    {
        $estudiantesData = [
            2001 => ['facultad' => 'Ingeniería', 'carrera' => 'Ingeniería de Sistemas', 'semestre' => 5],
            2002 => ['facultad' => 'Ciencias de la Salud', 'carrera' => 'Enfermería', 'semestre' => 3],
            2003 => ['facultad' => 'Ingeniería', 'carrera' => 'Ingeniería Civil', 'semestre' => 8],
            2004 => ['facultad' => 'Artes', 'carrera' => 'Artes Visuales', 'semestre' => 2],
            2005 => ['facultad' => 'Ciencias Económicas', 'carrera' => 'Contaduría Pública', 'semestre' => 6],
            2006 => ['facultad' => 'Ciencias de la Salud', 'carrera' => 'Psicología', 'semestre' => 4],
        ];

        foreach ($estudiantesData as $id => $data) {
            $user = User::where('identificacion', $id)->first();
            if ($user) {
                Estudiante::create([
                    'usuario_id' => $user->id,
                    'facultad' => $data['facultad'],
                    'nombre_carrera' => $data['carrera'],
                    'semestre' => $data['semestre'],
                ]);
            }
        }
    }
}
