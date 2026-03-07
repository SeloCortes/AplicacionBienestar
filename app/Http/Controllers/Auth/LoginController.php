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

        if (!$user || !Hash::check($request->password, $user->password)) {
            $msg = 'Credenciales incorrectas';
            if ($request->expectsJson()) {
                return response()->json(['message' => $msg, 'errors' => ['identificacion' => [$msg]]], 401);
            }
            return redirect()->route('login')->withErrors(['identificacion' => $msg])
                ->withInput($request->only('identificacion'));
        }

        // Autenticar al usuario y regenerar sesión
        Auth::login($user);
        $request->session()->regenerate();

        // Determinar ruta de redirección
        $redirectUrl = route('cursos.index');
        if ($user->administrativo) {
            $redirectUrl = route('admin.cursos.index');
        }

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Inicio de sesión exitoso',
                'redirect_url' => $redirectUrl
            ]);
        }

        return redirect()->to($redirectUrl)->with('message', 'Inicio de sesión exitoso');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }
}
