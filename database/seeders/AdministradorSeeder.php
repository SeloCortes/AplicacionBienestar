<?php

namespace Database\Seeders;

use App\Models\Administrativo;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdministradorSeeder extends Seeder
{
    public function run()
    {
        $adminProfiles = [
            ['id' => 1001, 'area' => 'Deporte Formativo', 'rol' => 'Coordinador'],
            ['id' => 1002, 'area' => 'Arte y Cultura', 'rol' => 'Coordinador'],
            ['id' => 1003, 'area' => 'Cátedra Santiaguina', 'rol' => 'Coordinador'],
            ['id' => 1004, 'area' => 'Bienestar Universitario', 'rol' => 'Director'],
            ['id' => 1005, 'area' => 'Sistemas', 'rol' => 'Administrador'],
        ];

        foreach ($adminProfiles as $profile) {
            $user = User::where('identificacion', $profile['id'])->first();
            if ($user) {
                Administrativo::updateOrCreate(
                    ['usuario_id' => $user->id],
                    [
                        'area' => $profile['area'],
                        'rol' => $profile['rol'],
                    ]
                );
            }
        }
    }
}
