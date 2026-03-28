<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use App\Models\Inscripcion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;



class InscripcionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'horario_id' => 'required|exists:horarios,id',
        ]);

        $user = auth()->user();
        $limiterKey = 'inscripcion-accion-' . $user->id;

        // Validacion de tiempo de espera (1 minuto)
        if (RateLimiter::tooManyAttempts($limiterKey, 1)) {
            $segundosRestantes = RateLimiter::availableIn($limiterKey);
            return response()->json([
                'message' => "Debes esperar {$segundosRestantes} segundos para realizar otra acción."
            ], 429);
        }

        return DB::transaction(function () use ($user, $request, $limiterKey) {
            $horario = Horario::with('curso')->lockForUpdate()->findOrFail($request->horario_id);

            // valida si el horario esta activo
            if (! $horario->estado) {
                return response()->json(['message' => 'Horario no disponible'], 400);
            }

            // valida si el horario tiene cupos disponibles
            if ($horario->cupo_disponible <= 0) {
                return response()->json(['message' => 'No cupos disponibles'], 400);
            }

            // validar que no este inscripto aun 
            $estadoInscripcion = Inscripcion::where('usuario_id', $user->id)
                ->where('horario_id', $horario->id)
                ->exists();

            if ($estadoInscripcion) {
                return response()->json(['message' => 'Usuario ya se encuentra inscripto a este horario'], 400);
            }

            // validacion por si el usuario ya esta inscripto a otro curso del mismo tipo (solo se permite una inscripcion por tipo)
            $categoria = $horario->curso->tipo_curso;

            $inscriptoCategoria = Inscripcion::where('usuario_id', $user->id)
                ->whereHas('horario.curso', function ($query) use ($categoria) {
                    $query->where('tipo_curso', $categoria);
                })
                ->exists();

            if ($inscriptoCategoria) {
                return response()->json([
                    'message' => "Usuario ya se encuentra inscripto a un curso de {$categoria}"
                ], 400);
            }

            Inscripcion::create([
                'usuario_id' => $user->id,
                'horario_id' => $horario->id,
                'tipo_inscripcion' => $user->estudiante ? 'estudiante' : 'tercero',
            ]);

            $horario->decrement('cupo_disponible');

            // Registrar la acción para bloquear futuras peticiones por 60 segundos
            RateLimiter::hit($limiterKey, 60);

            return response()->json([
                'message' => 'Inscripcion exitosa'
            ], 201);
        });
    }

    public function destroy($id)
    {
        $userId = auth()->user()->id;
        $limiterKey = 'inscripcion-accion-' . $userId;

        // Validacion de tiempo de espera (1 minuto) antes de borrar usando RateLimiter
        if (RateLimiter::tooManyAttempts($limiterKey, 1)) {
            $segundosRestantes = RateLimiter::availableIn($limiterKey);
            return response()->json([
                'message' => "Debes esperar {$segundosRestantes} segundos para realizar otra acción."
            ], 429);
        }

        return DB::transaction(function () use ($userId, $id, $limiterKey) {
            $inscripcion = Inscripcion::where('id', $id)
                ->where('usuario_id', $userId)
                ->lockForUpdate()
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

            // Registrar la acción para bloquear futuras peticiones por 60 segundos
            RateLimiter::hit($limiterKey, 60);

            return response()->json([
                'message' => 'Inscripcion cancelada exitosamente'
            ]);
        });
    } 
}
