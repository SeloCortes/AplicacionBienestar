<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Horario;
use App\Models\Inscripcion;

class CursosController extends Controller
{
    // Método para mostrar la lista de cursos disponibles
    public function index()
    {
        // Query para obtener solo los cursos activos
        $cursos = Curso::where('estado', true)->get();
        
        // Obtener inscripciones del usuario actual con info del curso
        $userInscriptions = [];
        if (auth()->check()) {
            $userInscriptions = Inscripcion::where('usuario_id', auth()->id())
                ->with('horario.curso')
                ->get();
        }

        // Retornar la vista con la lista de cursos e inscripciones
        return response()->view('cursos.student', compact('cursos', 'userInscriptions'));
    }

    // Método para obtener horarios de un curso específico
    public function horarios($cursoId)
    {
        // Query para obtener solo los horarios activos del curso seleccionado (Curso_id)
        $horariosCurso = Horario::where('curso_id', $cursoId)->where('estado', true)->get();

        // Retornar los horarios en formato JSON envueltos en un objeto
        return response()->json(['horarios' => $horariosCurso]);
    }
}
