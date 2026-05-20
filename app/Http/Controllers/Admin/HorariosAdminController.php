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

        $updates = [];

        if ($request->has('cupo_maximo_estudiante') && $request->cupo_maximo_estudiante != $horario->cupo_maximo_estudiante) {
            $diferencia = $request->cupo_maximo_estudiante - $horario->cupo_maximo_estudiante;
            $nuevoCupoDisponible = $horario->cupo_disponible_estudiante + $diferencia;
            $updates['cupo_disponible_estudiante'] = $nuevoCupoDisponible < 0 ? 0 : $nuevoCupoDisponible;
        }

        if ($request->has('cupo_maximo_tercero') && $request->cupo_maximo_tercero != $horario->cupo_maximo_tercero) {
            $diferencia = $request->cupo_maximo_tercero - $horario->cupo_maximo_tercero;
            $nuevoCupoDisponible = $horario->cupo_disponible_tercero + $diferencia;
            $updates['cupo_disponible_tercero'] = $nuevoCupoDisponible < 0 ? 0 : $nuevoCupoDisponible;
        }

        if (!empty($updates)) {
            $request->merge($updates);
        }

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
