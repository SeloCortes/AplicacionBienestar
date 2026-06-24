<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inscripcion;
use App\Models\Curso;
use App\Models\Horario;
use App\Models\Estudiante;
use Illuminate\Support\Facades\DB;

class InformesAdminController extends Controller
{
    // Funcion para generar informes
    public function index(Request $request)
    {
        // Validar filtros
        $tipoCurso = $request->input('tipo_curso', 'Deporte formativo');
        $cursoId = $request->input('curso_id', 'todos');
        $estamento = $request->input('estamento', 'todos');
        $facultad = $request->input('facultad', 'todos');
        $programa = $request->input('programa', 'todos');

        // Filtrar los tipos de curso según el área del administrador
        $user = auth()->user();
        $area = $user->administrativo->area ?? '';

        $areaMap = [
            'Deporte Formativo' => 'Deporte formativo',
            'Arte y Cultura' => 'Arte y cultura',
            'Cátedra Santiaguina' => 'Catedra Santiaguina'
        ];
        $tipoCursoFiltrado = $areaMap[$area] ?? $area;

        if (in_array($area, ['Bienestar Universitario', 'Sistemas'])) {
            $tiposDeCursos = ['Deporte formativo', 'Arte y cultura', 'Catedra Santiaguina'];
        } else {
            $tiposDeCursos = [$tipoCursoFiltrado];
        }

        $estadisticas = [];

        foreach ($tiposDeCursos as $tipo) {
            $numCursos = Curso::where('tipo_curso', $tipo)->count();
            
            $numHorarios = Horario::whereHas('curso', function($q) use ($tipo) {
                $q->where('tipo_curso', $tipo);
            })->count();
            
            $horariosLlenos = Horario::whereHas('curso', function($q) use ($tipo) {
                $q->where('tipo_curso', $tipo);
            })
            ->where('cupo_disponible_estudiante', '<=', 0)
            ->where('cupo_disponible_tercero', '<=', 0)
            ->count();
            
            // Inscritos por facultad (sólo estudiantes reales)
            $porFacultad = DB::table('inscripciones')
                ->join('horarios', 'inscripciones.horario_id', '=', 'horarios.id')
                ->join('cursos', 'horarios.curso_id', '=', 'cursos.id')
                ->join('estudiantes', 'inscripciones.usuario_id', '=', 'estudiantes.usuario_id')
                ->where('cursos.tipo_curso', $tipo)
                ->groupBy('estudiantes.facultad')
                ->selectRaw('estudiantes.facultad, count(*) as total')
                ->pluck('total', 'facultad')
                ->toArray();

            // Lista de cursos inscritos para el modal
            $listaCursosInscritos = DB::table('inscripciones')
                ->join('horarios', 'inscripciones.horario_id', '=', 'horarios.id')
                ->join('cursos', 'horarios.curso_id', '=', 'cursos.id')
                ->where('cursos.tipo_curso', $tipo)
                ->select(
                    'cursos.codigo as codigo',
                    'cursos.nombre as nombre',
                    'horarios.dia as dia',
                    'horarios.hora_inicio',
                    'horarios.hora_fin',
                    DB::raw('count(inscripciones.id) as total_inscripciones')
                )
                ->groupBy('cursos.codigo', 'cursos.nombre', 'horarios.dia', 'horarios.hora_inicio', 'horarios.hora_fin')
                ->get()
                ->map(function ($item) {
                    $item->rango_horas = $item->hora_inicio . ' - ' . $item->hora_fin;
                    return $item;
                });
            // Pre-calcular la cuenta de horarios por curso y día para evitar el problema N+1
            $conteoHorarios = DB::table('horarios')
                ->join('cursos', 'horarios.curso_id', '=', 'cursos.id')
                ->where('cursos.tipo_curso', $tipo)
                ->select('cursos.codigo', 'horarios.dia', DB::raw('count(*) as count'))
                ->groupBy('cursos.codigo', 'horarios.dia')
                ->get()
                ->keyBy(function($item) {
                    return $item->codigo . '-' . $item->dia;
                });

            // Añadir cuenta de horarios a cada item
            foreach ($listaCursosInscritos as $item) {
                $key = $item->codigo . '-' . $item->dia;
                $item->numero_horarios = isset($conteoHorarios[$key]) ? $conteoHorarios[$key]->count : 0;
            }

            // Lista de horarios sin cupos para el modal
            $listaHorariosSinCupos = Horario::with('curso')->whereHas('curso', function($q) use ($tipo) {
                $q->where('tipo_curso', $tipo);
            })
            ->where('cupo_disponible_estudiante', '<=', 0)
            ->where('cupo_disponible_tercero', '<=', 0)
            ->get()
            ->map(function ($horario) {
                return (object)[
                    'codigo' => $horario->codigo ?? 'N/A',
                    'nombre_curso' => $horario->curso->nombre,
                    'profesor' => $horario->profesor,
                    'dia' => $horario->dia,
                    'rango_horas' => $horario->hora_inicio . ' - ' . $horario->hora_fin
                ];
            });

            $estadisticas[$tipo] = [
                'cursos' => $numCursos,
                'horarios' => $numHorarios,
                'horarios_llenos' => $horariosLlenos,
                'por_facultad' => $porFacultad,
                'lista_cursos_inscritos' => $listaCursosInscritos,
                'lista_horarios_sin_cupos' => $listaHorariosSinCupos,
            ];
        }

        // 2. Listas para llenar filtros dinámicos
        $facultades = Estudiante::whereNotNull('facultad')
            ->where('facultad', '!=', '')
            ->distinct()
            ->orderBy('facultad')
            ->pluck('facultad')
            ->toArray();

        $programasQuery = Estudiante::whereNotNull('nombre_carrera')
            ->where('nombre_carrera', '!=', '')
            ->distinct();

        if ($facultad !== 'todos') {
            $programasQuery->where('facultad', $facultad);
        }

        $programas = $programasQuery->orderBy('nombre_carrera')
            ->pluck('nombre_carrera')
            ->toArray();

        // Si el programa previamente seleccionado ya no pertenece a la facultad seleccionada, se resetea a "todos"
        if ($programa !== 'todos' && !in_array($programa, $programas)) {
            $programa = 'todos';
        }

        // 3. Cursos para alimentar las columnas y filtros de la categoría seleccionada
        $cursosTipo = Curso::where('tipo_curso', $tipoCurso)->get();

        // Si se filtra para un curso específico, eliminamos los demás de las columnas
        if ($cursoId !== 'todos') {
            $cursoEspecifico = Curso::find($cursoId);
            $nombresCursos = $cursoEspecifico ? [$cursoEspecifico->nombre] : [];
        } else {
            $nombresCursos = $cursosTipo->pluck('nombre')->toArray();
        }

        // Query principal de inscripciones con Eager Loading para evitar N+1
        $query = Inscripcion::with(['user.estudiante', 'user.tercero', 'user.administrativo', 'horario.curso'])
            ->whereHas('horario.curso', function($q) use ($tipoCurso) {
                $q->where('tipo_curso', $tipoCurso);
            });

        // Filtrar por curso específico si aplica
        if ($cursoId !== 'todos') {
            $query->whereHas('horario', function($q) use ($cursoId) {
                $q->where('curso_id', $cursoId);
            });
        }

        // Filtrar por Estamento (Estudiante / Tercero)
        if ($estamento === 'Estudiante') {
            $query->whereHas('user.estudiante');
        } elseif ($estamento === 'Tercero') {
            $query->whereHas('user.tercero');
        }

        // Filtrar por Facultad
        if ($facultad !== 'todos') {
            $query->whereHas('user.estudiante', function($q) use ($facultad) {
                $q->where('facultad', $facultad);
            });
        }

        // Filtrar por Programa académico
        if ($programa !== 'todos') {
            $query->whereHas('user.estudiante', function($q) use ($programa) {
                $q->where('nombre_carrera', $programa);
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
                $est = $u ? $u->estudiante : null;
                $ter = $u ? $u->tercero : null;
                $admin = $u ? $u->administrativo : null;
                
                // Determinar Estamento y evitar valores N/A genéricos
                if ($est) {
                    $estamentoRow = 'Estudiante';
                    $facultadRow = $est->facultad ?: 'N/A';
                    $programaRow = $est->nombre_carrera ?: 'N/A';
                } elseif ($ter) {
                    $estamentoRow = 'Tercero';
                    $facultadRow = 'No aplica';
                    $programaRow = 'No aplica';
                } elseif ($admin) {
                    $estamentoRow = 'Administrativo';
                    $facultadRow = 'No aplica';
                    $programaRow = 'No aplica';
                } else {
                    $estamentoRow = 'N/A';
                    $facultadRow = 'N/A';
                    $programaRow = 'N/A';
                }
                
                $estudiantesPivot[$userId] = [
                    'ID' => $consecutivo++,
                    'Fecha y Hora de inscripcion' => $inscripcion->created_at->format('d/m/Y H:i:s'),
                    'Nombre y Apellidos Completos' => $u ? $u->nombre_apellido : 'N/A',
                    'Registre el Número de Documento de identidad' => $u ? $u->identificacion : 'N/A',
                    'Teléfono de Contacto' => $u ? $u->telefono : 'N/A',
                    'Correo Electrónico' => $u ? $u->correo : 'N/A',
                    'Estamento' => $estamentoRow,
                    'Seleccione la Facultad a la cual pertenece' => $facultadRow,
                    'Selecciona el Programa Académico' => $programaRow,
                ];
                
                // Inicializar las columnas dinámicas filtradas
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

        return view('administrador.informe', compact(
            'estudiantesPivot', 
            'nombresCursos', 
            'cursosTipo', 
            'tipoCurso', 
            'cursoId',
            'estadisticas',
            'facultades',
            'programas',
            'estamento',
            'facultad',
            'programa'
        ));
    }
}
