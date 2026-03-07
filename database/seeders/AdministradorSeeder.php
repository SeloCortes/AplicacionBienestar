<?php

namespace Database\Seeders;

use App\Models\Administrativo;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdministradorSeeder extends Seeder
{
    public function run()
    {
        $users = User::whereIn('identificacion', [12345, 12346])->get();

        foreach ($users as $user) {
            Administrativo::create([
                'usuario_id' => $user->id,
                'area' => 'Bienestar Universitario',
                'rol' => 'Administrador',
            ]);
        }
    }
}
