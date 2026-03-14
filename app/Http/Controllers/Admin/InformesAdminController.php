<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inscripcion;
use App\Models\Horario;

class InformesAdminController extends Controller
{
    //Funcion para generar informes

    //Carga vista para configurar generador de informes
    public function index()
    {
        return view("admin.informes.index");
    }

    //Funcion para generar informes
    public function generar(Request $request)
    {
        //Validamos request para que acepte los 3 tipos de cursos (Deporte formativo, Arte y Cultura, Catedra Santiaguina)
        $request->validate([
            'tipo_curso' => 'required|in:deporte,arte,catedra',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
        ]);

        $tipoCurso = $request->tipo_curso;
        $fechaInicio = $request->fecha_inicio;
        $fechaFin = $request->fecha_fin;
        

        //Query para obtener horario y cursos, y lista de usuarios inscritos para cada horario
        $horarios = Horario::where('curso_id', $tipoCurso)
            ->whereBetween('fecha_inicio', [$fechaInicio, $fechaFin])
            ->whereBetween('fecha_fin', [$fechaInicio, $fechaFin])
            ->get();

        //Query para obtener lista de usuarios inscritos
        $inscripciones = Inscripcion::where('curso_id', $tipoCurso)
            ->whereBetween('fecha_inicio', [$fechaInicio, $fechaFin])
            ->whereBetween('fecha_fin', [$fechaInicio, $fechaFin])
            ->get();
            return view('', compact('','',''));

        //Retornar la vista con la lista de horarios y usuarios inscritos
        return view('admin.informes.index', compact('horarios', 'inscripciones'));

    }
}
