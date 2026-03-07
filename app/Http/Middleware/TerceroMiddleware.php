<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class TerceroMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (! auth()->check() || ! auth()->user()->tercero) {
            return response()->json(['message' => 'Acceso denegado, acceso solo a terceros.'], 403);
        }

        return $next($request);
    }
}
