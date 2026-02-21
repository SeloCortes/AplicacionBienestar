<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Horario;

class CursosController extends Controller
{
    // Método para mostrar la lista de cursos disponibles
    public function index()
    {
        // Query para obtener solo los cursos activos
        $cursos = Curso::where('estado', true)->get();

        // Retornar la vista con la lista de cursos
        return response()->view('cursos.student', compact('cursos'));
    }

    // Método para obtener horarios de un curso específico
    public function horarios($cursoId)
    {
        // Query para obtener solo los horarios activos del curso seleccionado (Curso_id)
        $horariosCurso = Horario::where('curso_id', $cursoId)->where('estado', true)->get();

        // Retornar los horarios en formato JSON
        return response()->json($horariosCurso);
    }
}
