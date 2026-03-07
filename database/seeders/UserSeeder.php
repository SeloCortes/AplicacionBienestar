<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Administradores
        User::create([
            'identificacion' => 12345,
            'nombre_apellido' => 'Administrador Uno',
            'correo' => 'administrador1@gmail.com',
            'password' => Hash::make('1234'),
            'telefono' => '3001234567',
            'genero' => 'Masculino',
        ]);

        User::create([
            'identificacion' => 12346,
            'nombre_apellido' => 'Administrador Dos',
            'correo' => 'administrador2@gmail.com',
            'password' => Hash::make('1234'),
            'telefono' => '3001234568',
            'genero' => 'Femenino',
        ]);

        // Estudiantes
        User::create([
            'identificacion' => 12347,
            'nombre_apellido' => 'Estudiante Uno',
            'correo' => 'estudiante1@gmail.com',
            'password' => Hash::make('1234'),
            'telefono' => '3001234569',
            'genero' => 'Masculino',
        ]);

        User::create([
            'identificacion' => 12348,
            'nombre_apellido' => 'Estudiante Dos',
            'correo' => 'estudiante2@gmail.com',
            'password' => Hash::make('1234'),
            'telefono' => '3001234570',
            'genero' => 'Femenino',
        ]);

        // Tercero
        User::create([
            'identificacion' => 12349,
            'nombre_apellido' => 'Tercero Uno',
            'correo' => 'tercero1@gmail.com',
            'password' => Hash::make('1234'),
            'telefono' => '3001234571',
            'genero' => 'Masculino',
        ]);
    }
}
