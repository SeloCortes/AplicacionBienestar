<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Curso;
use Illuminate\Http\Request;

class CursosAdminController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $area = $user->administrativo->area ?? '';

        $areaMap = [
            'Deporte Formativo' => 'Deporte formativo',
            'Arte y Cultura' => 'Arte y cultura',
            'Cátedra Santiaguina' => 'Catedra Santiaguina'
        ];
        $tipoCursoFiltrado = $areaMap[$area] ?? $area;

        if (in_array($area, ['Bienestar Universitario', 'Sistemas'])) {
            $cursos = Curso::all();
            $tiposDeCursosPermitidos = ['Deporte formativo', 'Arte y cultura', 'Catedra Santiaguina'];
        } else {
            $cursos = Curso::where('tipo_curso', $tipoCursoFiltrado)->get();
            $tiposDeCursosPermitidos = [$tipoCursoFiltrado];
        }

        return view('administrador.adminCursos', compact('cursos', 'tiposDeCursosPermitidos'));
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
