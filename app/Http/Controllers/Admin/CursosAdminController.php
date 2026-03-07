<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Curso;
use Illuminate\Http\Request;

class CursosAdminController extends Controller
{
    public function index()
    {
        // Query para obtener todos los cursos.
        $cursos = Curso::all();

        // Retornar la vista con la lista de cursos
        return view('administrador.adminCursos', compact('cursos'));
    }

    public function store(Request $request)
    {
        $curso = Curso::create($request->all());

        return response()->json($curso, 201);
    }

    public function update(Request $request, $id)
    {
        $curso = Curso::findOrFail($id);
        $curso->update($request->all());

        return response()->json($curso);
    }

    public function destroy($id)
    {
        Curso::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Curso eliminado',
        ]);
    }
}
