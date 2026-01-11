<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use Illuminate\Http\Request;

class CursosController extends Controller
{
    public function index(Request $request)
    {
        $query = Curso::where('estado', true);

        if ($request->filled('tipo_curso')) {
            $query->where('tipo_curso', $request->tipo_curso);
        }

        $cursos = $query->with('horarios')->get();

        return response()->json($cursos);
    }



    public function horarios($cursoId)
    {
        $horariosCurso = Curso::with(['horarios' => function ($query) {
            $query->where('estado', true)
                  ->where('cupo_disponible', '>', 0);
        }])->findOrFail($cursoId);

        return response()->json($horariosCurso);
    }

}

