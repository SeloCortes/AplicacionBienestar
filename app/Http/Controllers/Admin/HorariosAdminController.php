<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Horario;
use App\Models\Curso;
use Illuminate\Http\Request;

class HorariosAdminController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->all();

        if (empty($data['codigo'])) {
            $curso = Curso::findOrFail($data['curso_id']);
            $codigoBase = $curso->codigo;
            
            if ($codigoBase) {
                $ultimoHorario = Horario::where('curso_id', $curso->id)
                                        ->where('codigo', 'like', $codigoBase . '%')
                                        ->orderBy('id', 'desc')
                                        ->first();
                                        
                if ($ultimoHorario && $ultimoHorario->codigo) {
                    $suffix = substr($ultimoHorario->codigo, strlen($codigoBase));
                    if (empty($suffix) || !preg_match('/^[A-Z]+$/', $suffix)) {
                        $suffix = 'A';
                    } else {
                        $suffix++; 
                    }
                } else {
                    $suffix = 'A';
                }
                
                $data['codigo'] = $codigoBase . $suffix;
            }
        }

        $horario = Horario::create($data);

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
