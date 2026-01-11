<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Horario;
use Illuminate\Http\Request;

class HorariosAdminController extends Controller
{
    public function store(Request $request)
    {
        $horario = Horario::create($request->all());

        return response()->json($horario, 201);
    }

    public function update(Request $request, $id)
    {
        $horario = Horario::findOrFail($id);
        $horario->update($request->all());

        return response()->json($horario);
    }

    public function destroy($id)
    {
        Horario::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Horario eliminado'
        ]);
    }
}
