<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use App\Models\Inscripcion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InscripcionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'user_id'    => 'required|exists:users,id',
            'horario_id' => 'required|exists:horarios,id',
        ]);

        $user = User::findOrFail($request->user_id);
        $horario = Horario::with('curso')->findOrFail($request->horario_id);

        // valida si el horario esta activo
        if (! $horario->estado) {
            return response()->json(['message' => 'Horario no disponible'], 400);
        }

        // valida si el horario tiene cupos disponibles
        if ($horario->cupo_disponible <= 0) {
            return response()->json(['message' => 'No cupos disponibles'], 400);
        }

        // paso extra para validar que no este inscripto aun 
        $estadoInscripcion = Inscripcion::where('user_id', $user->id)
            ->where('horario_id', $horario->id)
            ->exists();

        if ($estadoInscripcion) {
            return response()->json(['message' => 'Usuario ya se encuentra inscripto a este horario'], 400);
        }

        // validacion por si el usuario ya esta inscripto a otro curso del mismo tipo (solo se permite una inscripcion por tipo)
        $categoria = $horario->curso->tipo_curso;

        $inscriptoCategoria = Inscripcion::where('user_id', $user->id)
            ->whereHas('horario.curso', function ($query) use ($categoria) {
                $query->where('tipo_curso', $categoria);
            })
            ->exists();

        if ($inscriptoCategoria) {
            return response()->json([
                'message' => "Usuario ya se encuentra inscripto a un curos de  {$categoria}"
            ], 400);
        }

        // 5️⃣ Transaction (safe capacity update)
        DB::transaction(function () use ($user, $horario) {
            Inscripcion::create([
                'user_id' => $user->id,
                'horario_id' => $horario->id,
                'tipo_inscripcion' => $user->estudiante ? 'estudiante' : 'tercero',
            ]);

            $horario->decrement('cupo_disponible');
        });

        return response()->json([
            'message' => 'Inscripcion exitosa'
        ], 201);
    }

    public function destroy(Request $request, $id)
    {
        $userId = $request->input('user_id');

        $inscripcion = Inscripcion::where('id', $id)
            ->where('usuario_id', $userId)
            ->first();

        if (! $inscripcion) {
            return response()->json([
                'message' => 'Error: Inscripcion no existe'
            ], 404);
        }

        $horario = Horario::find($inscripcion->horario_id);

        if ($horario) {
            $horario->increment('cupo_disponible');
        }

        $inscripcion->delete();

        return response()->json([
            'message' => 'Inscripcion cancelada exitosamente'
        ]);
    } 
}
