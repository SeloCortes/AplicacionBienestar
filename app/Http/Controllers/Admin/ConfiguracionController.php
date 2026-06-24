<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Configuracion;

class ConfiguracionController extends Controller
{
    public function index()
    {
        // Obtener la configuración actual o crearla si no existe
        $estado = Configuracion::firstOrCreate(
            ['clave' => 'estado_global_inscripciones'],
            ['valor' => 'activo']
        );

        $fechaInicio = Configuracion::firstOrCreate(
            ['clave' => 'fecha_inicio_inscripciones'],
            ['valor' => null]
        );

        $fechaFin = Configuracion::firstOrCreate(
            ['clave' => 'fecha_fin_inscripciones'],
            ['valor' => null]
        );

        return view('administrador.configuracion', compact('estado', 'fechaInicio', 'fechaFin'));
    }

    public function update(Request $request)
    {
        if ($request->has('estado_global_inscripciones')) {
            Configuracion::where('clave', 'estado_global_inscripciones')
                ->update(['valor' => $request->estado_global_inscripciones]);
        }

        if ($request->has('fecha_inicio_inscripciones')) {
            Configuracion::where('clave', 'fecha_inicio_inscripciones')
                ->update(['valor' => $request->fecha_inicio_inscripciones]);
        }

        if ($request->has('fecha_fin_inscripciones')) {
            Configuracion::where('clave', 'fecha_fin_inscripciones')
                ->update(['valor' => $request->fecha_fin_inscripciones]);
        }

        return redirect()->back()->with('success', 'Configuración actualizada correctamente.');
    }
}
