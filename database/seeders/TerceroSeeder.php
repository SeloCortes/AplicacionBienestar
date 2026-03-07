<?php

namespace Database\Seeders;

use App\Models\Tercero;
use App\Models\User;
use Illuminate\Database\Seeder;

class TerceroSeeder extends Seeder
{
    public function run()
    {
        $user = User::where('identificacion', 12349)->first();

        if ($user) {
            Tercero::create([
                'usuario_id' => $user->id,
                'estamento' => 'Profesor',
            ]);
        }
    }
}
