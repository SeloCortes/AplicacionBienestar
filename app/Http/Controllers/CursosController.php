<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Horario;
use App\Models\Inscripcion;
use App\Models\Configuracion;

class CursosController extends Controller
{
    // Método para mostrar la lista de cursos disponibles
    public function index()
    {
        // Query para obtener solo los cursos activos
        $cursos = Curso::where('activo', true)->get();
        
        // Obtener inscripciones del usuario actual con info del curso
        $userInscriptions = [];
        if (auth()->check()) {
            $userInscriptions = Inscripcion::where('usuario_id', auth()->id())
                ->with('horario.curso')
                ->get();
        }

        $inscripcionesAbiertas = $this->verificarInscripcionesAbiertas();

        // Retornar la vista con la lista de cursos e inscripciones
        return response()->view('cursos.estudiante', compact('cursos', 'userInscriptions', 'inscripcionesAbiertas'));
    }

    // Método para mostrar la vista de los cursos inscritos por el usuario
    public function misCursos()
    {
        $userInscriptions = [];
        if (auth()->check()) {
            $userInscriptions = Inscripcion::where('usuario_id', auth()->id())
                ->with('horario.curso')
                ->get();
            $inscripcionesAbiertas = $this->verificarInscripcionesAbiertas();
            return response()->view('cursos.misCursos', compact('userInscriptions', 'inscripcionesAbiertas'));
        }
        return redirect('/login');
    }

    // Método para obtener horarios de un curso específico
    public function horarios($cursoId)
    {
        // Query para obtener TODOS los horarios del curso seleccionado (Curso_id)
        $horariosCurso = Horario::where('curso_id', $cursoId)->get();

        if (auth()->check()) {
            $user = auth()->user();
            $tipo = $user->estudiante ? 'estudiante' : 'tercero';
            
            $horariosCurso->transform(function ($horario) use ($tipo) {
                $horario->cupo_maximo = $horario->{'cupo_maximo_' . $tipo};
                $horario->cupo_disponible = $horario->{'cupo_disponible_' . $tipo};
                return $horario;
            });
        }

        // Retornar los horarios en formato JSON envueltos en un objeto
        return response()->json(['horarios' => $horariosCurso]);
    }

    private function verificarInscripcionesAbiertas()
    {
        $estadoGlobal = Configuracion::where('clave', 'estado_global_inscripciones')->value('valor') ?? 'activo';
        if ($estadoGlobal === 'inactivo') return false;

        $fechaInicio = Configuracion::where('clave', 'fecha_inicio_inscripciones')->value('valor');
        $fechaFin = Configuracion::where('clave', 'fecha_fin_inscripciones')->value('valor');
        $ahora = now();

        if ($fechaInicio && $ahora->lt(\Carbon\Carbon::parse($fechaInicio))) return false;
        if ($fechaFin && $ahora->gt(\Carbon\Carbon::parse($fechaFin))) return false;

        return true;
    }
}
