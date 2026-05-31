<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    /**
     * Mostrar el formulario de registro.
     */
    public function showRegistrationForm()
    {
        // Obtener mapeo de facultades y sus respectivos programas
        $facultadesProgramas = \App\Models\Estudiante::whereNotNull('facultad')
            ->where('facultad', '!=', '')
            ->whereNotNull('nombre_carrera')
            ->where('nombre_carrera', '!=', '')
            ->select('facultad', 'nombre_carrera')
            ->distinct()
            ->get()
            ->groupBy('facultad')
            ->map(function ($items) {
                return $items->pluck('nombre_carrera')->sort()->values();
            })
            ->toArray();

        $facultades = array_keys($facultadesProgramas);
        sort($facultades);

        return view('auth.register', compact('facultades', 'facultadesProgramas'));
    }

    /**
     * Procesar el registro de un nuevo usuario.
     */
    public function store(RegisterUserRequest $request)
    {
        // Los datos ya fueron validados en RegisterUserRequest

        $user = DB::transaction(function () use ($request) {
            // 1. Crear el usuario base
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

            // 2. Crear la especialización según el rol
            if ($request->rol === 'Estudiante') {
                $user->estudiante()->create([
                    'facultad'       => $request->facultad,
                    'nombre_carrera' => $request->nombre_carrera,
                    'semestre'       => $request->semestre,
                ]);
            } elseif ($request->rol === 'Tercero') {
                $user->tercero()->create([
                    'estamento'      => $request->estamento,
                ]);
            }

            return $user;
        });

        return response()->json([
            'message' => 'Usuario registrado exitosamente',
            'user_id' => $user->id,
        ], 201);
    }
}
