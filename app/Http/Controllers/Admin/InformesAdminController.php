<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inscripcion;
use App\Models\Curso;

class InformesAdminController extends Controller
{
    //Funcion para generar informes

    public function index(Request $request)
    {
        // Validar filtros
        $tipoCurso = $request->input('tipo_curso', 'Deporte formativo');
        $cursoId = $request->input('curso_id', 'todos');

        // Cursos para alimentar las columnas y filtros de la categoría seleccionada
        $cursosTipo = Curso::where('tipo_curso', $tipoCurso)->get();
        $nombresCursos = $cursosTipo->pluck('nombre')->toArray();

        // Query principal de inscripciones
        $query = Inscripcion::with(['user.estudiante', 'horario.curso'])
            ->whereHas('horario.curso', function($q) use ($tipoCurso) {
                $q->where('tipo_curso', $tipoCurso);
            });

        // Filtrar por curso específico si aplica
        if ($cursoId !== 'todos') {
            $query->whereHas('horario', function($q) use ($cursoId) {
                $q->where('curso_id', $cursoId);
            });
        }

        $inscripciones = $query->orderBy('created_at', 'desc')->get();

        $estudiantesPivot = [];
        $consecutivo = 1;

        foreach ($inscripciones as $inscripcion) {
            $userId = $inscripcion->usuario_id;
            
            // Si el usuario aún no está en nuestro pivot, lo agregamos
            if (!isset($estudiantesPivot[$userId])) {
                $u = $inscripcion->user;
                $est = $u->estudiante;
                
                $estudiantesPivot[$userId] = [
                    'ID' => $consecutivo++,
                    'Fecha y Hora de inscripcion' => $inscripcion->created_at->format('d/m/Y H:i:s'),
                    'Nombre y Apellidos Completos' => $u ? $u->nombre_apellido : 'N/A',
                    'Registre el Número de Documento de identidad' => $u ? $u->identificacion : 'N/A',
                    'Teléfono de Contacto' => $u ? $u->telefono : 'N/A',
                    'Correo Electrónico' => $u ? $u->correo : 'N/A',
                    'Seleccione la Facultad a la cual pertenece' => $est ? $est->facultad : 'N/A',
                    'Selecciona el Programa Académico' => $est ? $est->nombre_carrera : 'N/A',
                ];
                
                // Inicializar las columnas dinámicas (los cursos del tipo seleccionado)
                foreach ($nombresCursos as $nombreCurso) {
                    $estudiantesPivot[$userId][$nombreCurso] = '';
                }
            }
            
            // Asignar el texto de horario en lugar de una "X"
            $cursoActual = $inscripcion->horario->curso->nombre ?? null;
            if ($cursoActual && in_array($cursoActual, $nombresCursos)) {
                $horario = $inscripcion->horario;
                $inicio = \Carbon\Carbon::parse($horario->hora_inicio)->format('g:i a');
                $fin = \Carbon\Carbon::parse($horario->hora_fin)->format('g:i a');
                
                // Dar formato am/pm con puntos (a.m. p.m.)
                $inicio = str_replace(['am', 'pm'], ['a.m.', 'p.m.'], $inicio);
                $fin = str_replace(['am', 'pm'], ['a.m.', 'p.m.'], $fin);
                
                $profesor = $horario->profesor ?? 'Sin profesor asignado';
                $textoHorario = "{$horario->dia} {$inicio} a {$fin} - {$profesor}";
                
                $estudiantesPivot[$userId][$cursoActual] = $textoHorario;
            }
        }

        return view('admin.informe.index', compact('estudiantesPivot', 'nombresCursos', 'cursosTipo', 'tipoCurso', 'cursoId'));
    }
}
