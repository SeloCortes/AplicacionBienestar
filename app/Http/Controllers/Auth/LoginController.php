<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    // Manejo de inicio de sesión para usuarios recibe post con identificacion y password, valida las credenciales y redirige a la vista de cursos si son correctas, o muestra un error si no lo son.
    public function login(Request $request)
    {
        $request->validate([
            'identificacion' => 'required|integer',
            'password' => 'required|string',
        ]);

        $user = User::where('identificacion', $request->identificacion)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return redirect()->route('login')->withErrors(['identificacion' => 'Credenciales incorrectas'])
                ->withInput($request->only('identificacion'));
        }

        // Loguear usuario y regenerar sesión para evitar fijación de sesión
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended(route('cursos.index'))->with('message', 'Inicio de sesión exitoso');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }
}
