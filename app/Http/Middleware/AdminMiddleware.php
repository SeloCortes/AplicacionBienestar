<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $userId = $request->input('user_id');

        if (! $userId) {
            return response()->json(['message' => 'ID del usuario es necesario'], 401);
        }

        $user = User::find($userId);

        if (! $user || ! $user->administrativo) {
            return response()->json(['message' => 'Acceso denegado, acceso solo a administradores.'], 403);
        }

        return $next($request);
    }
}
