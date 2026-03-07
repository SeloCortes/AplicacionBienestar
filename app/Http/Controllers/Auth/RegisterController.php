<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    //

    public function store(RegisterUserRequest $request)
    {

        $request->validate([
            'nombre_apellido' => 'required|string|max:255',
            'identificacion' => 'required|digits_between:1,20|unique:users,identificacion',
            'correo' => 'required|string|email|max:255|unique:users,correo',
            'password' => 'required|string|min:8|confirmed',
            'telefono' => 'nullable|digits_between:1,10',
            'genero' => 'nullable|string|max:20',
            'etnia' => 'nullable|string|max:50',
            'discapacidad' => 'nullable|string|max:255',
        ]);

        $user = User::create([
            'nombre_apellido' => $request->nombre_apellido,
            'identificacion' => $request->identificacion,
            'correo' => $request->correo,
            'password' => Hash::make($request->password),
            'telefono' => $request->telefono,
            'genero' => $request->genero,
            'etnia' => $request->etnia,
            'discapacidad' => $request->discapacidad,
        ]);

        return response()->json([
            'message' => 'Usuario registrado exitosamente',
            'user_id' => $user->id,
        ], 201);
    }
}
