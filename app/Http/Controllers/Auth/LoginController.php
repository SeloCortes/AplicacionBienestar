<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'identificacion' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('identificacion', $request->identificacion)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Credenciales incorrectas'
            ], 401);
        }

        return response()->json([
            redirect('/cursos'),
            'message' => 'Inicio de sesión exitoso',
            'user_id' => $user->id,
            'nombre' => $user->nombre_apellido,
        ]);
    }
}