<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

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
            return redirect()->route('login')->withErrors(['identificacion' => 'Credenciales incorrectas'])
                ->withInput($request->only('identificacion'));
        }

        Auth::login($user, $remember = true);

        return redirect()->intended('/cursos')->with('message', 'Inicio de sesión exitoso');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }
}