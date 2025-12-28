<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\RegisterUserRequest;

use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    //


    
    public function store(RegisterUserRequest $request){

        $user = User::create([
            'nombre_apellido' => $request->nombre_apellido,
            'identificacion'  => $request->identificacion,
            'correo'          => $request->correo,
            'password'        => Hash::make($request->password),
            'telefono'        => $request->telefono,
            'genero'          => $request->genero,
            'etnia'           => $request->etnia,
            'discapacidad'    => $request->discapacidad,
        ]);

        return response()->json([
            'message' => 'Usuario registrado exitosamente',
            'user_id' => $user->id,
        ], 201);
    }
}
