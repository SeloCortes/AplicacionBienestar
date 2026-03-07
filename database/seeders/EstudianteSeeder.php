<?php

namespace Database\Seeders;

use App\Models\Estudiante;
use App\Models\User;
use Illuminate\Database\Seeder;

class EstudianteSeeder extends Seeder
{
    public function run()
    {
        $users = User::whereIn('identificacion', [12347, 12348])->get();

        foreach ($users as $index => $user) {
            Estudiante::create([
                'usuario_id' => $user->id,
                'facultad' => 'Ingeniería',
                'nombre_carrera' => $index == 0 ? 'Sistemas' : 'Civil',
                'semestre' => 5,
            ]);
        }
    }
}
