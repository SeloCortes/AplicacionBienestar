<?php

namespace Database\Seeders;

use App\Models\Tercero;
use App\Models\User;
use Illuminate\Database\Seeder;

class TerceroSeeder extends Seeder
{
    public function run()
    {
        $terceros = User::whereIn('identificacion', [3001, 3002])->get();

        foreach ($terceros as $index => $user) {
            Tercero::create([
                'usuario_id' => $user->id,
                'estamento' => $index == 0 ? 'Docente' : 'Egresado',
            ]);
        }
    }
}
