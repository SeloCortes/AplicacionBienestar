<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (! auth()->check() || ! auth()->user()->administrativo) {
            return response()->json(['message' => 'Acceso denegado, acceso solo a administradores.'], 403);
        }

        return $next($request);
    }
}
