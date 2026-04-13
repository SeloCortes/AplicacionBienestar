<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Administradores (Identificaciones 1001 - 1005)
        $admins = [
            ['id' => 1001, 'nombre' => 'Coordinador Deporte Formativo', 'correo' => 'deporte.formativo@bienestar.edu.co', 'tel' => '3104567890', 'gen' => 'Masculino'],
            ['id' => 1002, 'nombre' => 'Coordinador Arte y Cultura', 'correo' => 'arte.cultura@bienestar.edu.co', 'tel' => '3157891234', 'gen' => 'Femenino'],
            ['id' => 1003, 'nombre' => 'Coordinador Cátedra Santiaguina', 'correo' => 'catedra.santiaguina@bienestar.edu.co', 'tel' => '3157823614', 'gen' => 'Femenino'],
            ['id' => 1004, 'nombre' => 'Director de Bienestar', 'correo' => 'director.bienestar@bienestar.edu.co', 'tel' => '3101234567', 'gen' => 'Masculino'],
            ['id' => 1005, 'nombre' => 'Administrador de Sistemas', 'correo' => 'admin.sistemas@bienestar.edu.co', 'tel' => '3107654321', 'gen' => 'Masculino'],
        ];


        foreach ($admins as $admin) {
            User::updateOrCreate(
                ['identificacion' => $admin['id']],
                [
                    'nombre_apellido' => $admin['nombre'],
                    'correo' => $admin['correo'],
                    'password' => Hash::make('1234'),
                    'telefono' => $admin['tel'],
                    'genero' => $admin['gen'],
                ]
            );
        }
/*
        // Estudiantes (Identificaciones 2001 - 2010)
        $estudiantes = [
            ['id' => 2001, 'nombre' => 'Juan David Perez', 'correo' => 'juan.perez@estudiante.edu.co', 'tel' => '3001234567', 'gen' => 'Masculino'],
            ['id' => 2002, 'nombre' => 'Valentina Gomez', 'correo' => 'valentina.gomez@estudiante.edu.co', 'tel' => '3012345678', 'gen' => 'Femenino'],
            ['id' => 2003, 'nombre' => 'Mateo Rodriguez', 'correo' => 'mateo.rodriguez@estudiante.edu.co', 'tel' => '3023456789', 'gen' => 'Masculino'],
            ['id' => 2004, 'nombre' => 'Sofia Lopez', 'correo' => 'sofia.lopez@estudiante.edu.co', 'tel' => '3034567890', 'gen' => 'Femenino'],
            ['id' => 2005, 'nombre' => 'Sebastian Martinez', 'correo' => 'sebastian.martinez@estudiante.edu.co', 'tel' => '3045678901', 'gen' => 'Masculino'],
            ['id' => 2006, 'nombre' => 'Isabella Hernandez', 'correo' => 'isabella.hernandez@estudiante.edu.co', 'tel' => '3056789012', 'gen' => 'Femenino'],
        ];

        foreach ($estudiantes as $est) {
            User::create([
                'identificacion' => $est['id'],
                'nombre_apellido' => $est['nombre'],
                'correo' => $est['correo'],
                'password' => Hash::make('1234'),
                'telefono' => $est['tel'],
                'genero' => $est['gen'],
            ]);
        }

        // Terceros (Identificaciones 3001 - 3005)
        $terceros = [
            ['id' => 3001, 'nombre' => 'Ricardo Gutierrez', 'correo' => 'ricardo.gutierrez@externo.com', 'tel' => '3209876543', 'gen' => 'Masculino'],
            ['id' => 3002, 'nombre' => 'Gloria Esperanza Diaz', 'correo' => 'gloria.diaz@externo.com', 'tel' => '3218765432', 'gen' => 'Femenino'],
        ];

        foreach ($terceros as $ter) {
            User::create([
                'identificacion' => $ter['id'],
                'nombre_apellido' => $ter['nombre'],
                'correo' => $ter['correo'],
                'password' => Hash::make('1234'),
                'telefono' => $ter['tel'],
                'genero' => $ter['gen'],
            ]);
        }
 */    }
       
}
