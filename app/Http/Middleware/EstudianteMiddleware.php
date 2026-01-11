<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class EstudianteMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $userId = $request->input('user_id');

        if (! $userId) {
            return response()->json(['message' => 'ID del usuario es necesario'], 401);
        }

        $user = User::find($userId);

        if (! $user || ! $user->estudiante) {
            return response()->json(['message' => 'Acceso denegado, acceso solo a estudiantes.'], 403);
        }

        return $next($request);
    }
}

