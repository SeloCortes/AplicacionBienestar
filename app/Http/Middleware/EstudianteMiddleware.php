<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class EstudianteMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return response()->json(['message' => 'Acceso denegado, acceso solo a usuarios autenticados.'], 403);
        }

        return $next($request);
    }
}
