<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#0c1381">
    <title>Panel Admin - Informes de Inscripciones</title>
    <link rel="stylesheet" href="{{ asset('css/student.css') }}">
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    
    <style>
        .admin-controls { display: flex; gap: 0.5rem; margin-top: auto; }
        .hero-section {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border-radius: var(--radius-lg);
            margin-bottom: 2rem;
        }
        .filter-form {
            background: white;
            padding: 1.5rem;
            border-radius: var(--radius-lg);
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            margin-bottom: 2rem;
            display: flex;
            gap: 1rem;
            align-items: flex-end;
            flex-wrap: wrap;
        }
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            flex: 1;
            min-width: 180px;
        }
        .form-group label {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--foreground);
        }
        .form-group select {
            padding: 0.75rem;
            border-radius: var(--radius-md);
            border: 1px solid var(--border);
            font-family: inherit;
            background-color: white;
        }
        .btn-filter {
            background: var(--primary);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: var(--radius-md);
            font-weight: 600;
            border: none;
            cursor: pointer;
            height: 42px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        
        /* Stats Dashboard Section */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        .stats-card {
            background: white;
            border-radius: var(--radius-lg);
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            overflow: hidden;
            border: 1px solid var(--border);
            transition: transform 0.2s, box-shadow 0.2s;
            display: flex;
            flex-direction: column;
        }
        .stats-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1);
        }
        .stats-card-header {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: black;
            padding: 1rem 1.5rem;
        }
        .stats-card-header h3 {
            margin: 0;
            font-size: 1.1rem;
            font-weight: 600;
        }
        .stats-card-body {
            padding: 1.5rem;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }
        .stat-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem 0;
            border-bottom: 1px solid var(--border);
        }
        .stat-label {
            font-size: 0.9rem;
            color: var(--muted-foreground);
            font-weight: 500;
        }
        .stat-val {
            font-weight: 600;
            font-size: 0.9rem;
            padding: 0.2rem 0.6rem;
            border-radius: 9999px;
        }
        .badge-info { background: #e0f2fe; color: #0369a1; }
        .badge-secondary { background: #f3f4f6; color: #374151; }
        .badge-danger { background: #fee2e2; color: #b91c1c; }
        .badge-success { background: #dcfce7; color: #15803d; }

        .stat-faculties {
            margin-top: 1rem;
            border-top: 1px solid var(--border);
            padding-top: 1rem;
        }
        .stat-faculties h4 {
            margin: 0 0 0.5rem 0;
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--foreground);
        }
        .stat-faculties ul {
            list-style: none;
            padding: 0;
            margin: 0;
            max-height: 120px;
            overflow-y: auto;
        }
        .stat-faculties li {
            display: flex;
            justify-content: space-between;
            font-size: 0.85rem;
            padding: 0.25rem 0;
            border-bottom: 1px dashed var(--border);
        }
        .fac-name {
            color: var(--muted-foreground);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 80%;
        }
        .fac-count {
            font-weight: 600;
            color: var(--primary);
        }
        .no-data {
            font-size: 0.85rem;
            color: var(--muted-foreground);
            font-style: italic;
            margin: 0;
        }

        .table-container {
            background: white;
            padding: 1.5rem;
            border-radius: var(--radius-lg);
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            overflow-x: auto;
        }
        
        /* Ajustes DataTables */
        table.dataTable thead th, table.dataTable thead td {
            border-bottom: 2px solid var(--border);
            color: var(--foreground);
        }
        table.dataTable.no-footer {
            border-bottom: 1px solid var(--border);
        }
        .dt-buttons .dt-button {
            background: #10b981 !important; /* Verde Excel */
            color: white !important;
            border: none !important;
            border-radius: var(--radius-md) !important;
            padding: 0.5rem 1rem !important;
            font-weight: 600 !important;
            margin-bottom: 1rem;
        }
        
        .nav-button {
            background: rgba(255,255,255,0.1);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: var(--radius-md);
            text-decoration: none;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            border: 1px solid rgba(255,255,255,0.2);
        }
        .nav-button:hover { background: rgba(255,255,255,0.2); }
    </style>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="app-layout">
        <header class="main-header">
            <div class="header-inner">
                <div class="logo-link">
                    <div class="logo-icon">
                        <img src="{{ asset('images/Logo_Universidad-Santiago-de-Cali.png') }}" alt="Logo USC">
                    </div>
                    <div class="logo-text">
                        <span class="logo-title">SIBIU</span>
                        <span class="logo-subtitle">Bienestar USC</span>
                    </div>
                </div>

                <nav class="admin-nav" style="display: flex; gap: 1.5rem; margin-left: 2rem;">
                    <a href="{{ route('admin.cursos.index') }}" class="nav-link {{ request()->routeIs('admin.cursos.index') ? 'active' : '' }}" style="text-decoration: none; color: var(--muted-foreground); font-weight: 500; transition: all 0.2s;">Cursos</a>
                    <a href="{{ route('admin.informe.index') }}" class="nav-link {{ request()->routeIs('admin.informe.index') ? 'active' : '' }}" style="text-decoration: none; color: var(--primary); font-weight: 700; border-bottom: 2px solid var(--primary); padding-bottom: 4px;">Informes</a>
                    @if(in_array(auth()->user()->administrativo->area ?? '', ['Bienestar Universitario', 'Sistemas']))
                    <a href="{{ route('admin.configuracion.index') }}" class="nav-link" style="text-decoration: none; color: var(--muted-foreground); font-weight: 500;">Configuración</a>
                    @endif
                </nav>

                <div class="header-actions">
                    <form action="{{ url('/logout') }}" method="POST" class="logout-form">
                        @csrf
                        <button type="submit" class="logout-btn"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4m7 14 5-5-5-5m5 5H9"/></svg></button>
                    </form>
                </div>
            </div>
        </header>

        <main class="main-content">
            <div class="content-container">
                <section class="hero-section">
                    <div class="hero-text">
                        <h1>Informes de Inscripciones</h1>
                        <p>Genera reportes detallados y descárgalos en Excel.</p>
                    </div>
                </section>

                <!-- Panel de Estadísticas (3 Columnas) -->
                <div class="stats-grid">
                    @foreach ($estadisticas as $tipo => $datos)
                        <div class="stats-card">
                            <div class="stats-card-header">
                                <h3>{{ $tipo }}</h3>
                            </div>
                            <div class="stats-card-body">
                                <div class="stat-row">
                                    <span class="stat-label">Cursos creados</span>
                                    <span class="stat-val badge-info">{{ $datos['cursos'] }}</span>
                                </div>
                                <div class="stat-row">
                                    <span class="stat-label">Horarios programados</span>
                                    <span class="stat-val badge-secondary">{{ $datos['horarios'] }}</span>
                                </div>
                                <div class="stat-row">
                                    <span class="stat-label">Horarios sin cupos</span>
                                    <span class="stat-val {{ $datos['horarios_llenos'] > 0 ? 'badge-danger' : 'badge-success' }}">
                                        {{ $datos['horarios_llenos'] }}
                                    </span>
                                </div>
                                
                                <div class="stat-faculties">
                                    <h4>Inscritos por Facultad</h4>
                                    @if (count($datos['por_facultad']) > 0)
                                        <ul>
                                            @foreach ($datos['por_facultad'] as $fac => $cant)
                                                <li>
                                                    <span class="fac-name" title="{{ $fac }}">{{ $fac }}</span>
                                                    <span class="fac-count">{{ $cant }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p class="no-data">Sin inscritos</p>
                                    @endif
                                </div>
                                <div style="margin-top: 1rem; text-align: center;">
                                    <button class="btn-filter" style="width: 100%;" onclick="openDetailsModal('{{ md5($tipo) }}')">Ver Detalles</button>
                                </div>
                            </div>
                        </div>

                        <!-- Modal for Details -->
                        <div id="detailsModal_{{ md5($tipo) }}" class="modal-overlay" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center; padding: 1rem;">
                            <div class="modal-container" style="background: white; border-radius: 12px; width: 100%; max-width: 1000px; max-height: 90vh; overflow-y: auto; position: relative;">
                                <div style="padding: 1.5rem; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center;">
                                    <h3 style="margin: 0;">Detalles - {{ $tipo }}</h3>
                                    <button onclick="closeDetailsModal('{{ md5($tipo) }}')" style="background: none; border: none; font-size: 1.5rem; cursor: pointer;">&times;</button>
                                </div>
                                <div style="padding: 1.5rem;">
                                    <h4 style="margin-top: 0;">Cursos Inscritos</h4>
                                    @if(isset($datos['lista_cursos_inscritos']) && count($datos['lista_cursos_inscritos']) > 0)
                                        <table style="width: 100%; border-collapse: collapse; margin-bottom: 2rem;">
                                            <thead style="background: #f3f4f6;">
                                                <tr>
                                                    <th style="padding: 0.5rem; border: 1px solid var(--border); text-align: left;">Código</th>
                                                    <th style="padding: 0.5rem; border: 1px solid var(--border); text-align: left;">Nombre</th>
                                                    <th style="padding: 0.5rem; border: 1px solid var(--border); text-align: left;">Día</th>
                                                    <th style="padding: 0.5rem; border: 1px solid var(--border); text-align: left;">Rango de Horas</th>
                                                    <th style="padding: 0.5rem; border: 1px solid var(--border); text-align: left;">Horarios Programados</th>
                                                    <th style="padding: 0.5rem; border: 1px solid var(--border); text-align: left;">Total Inscritos</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($datos['lista_cursos_inscritos'] as $cursoDetalle)
                                                <tr>
                                                    <td style="padding: 0.5rem; border: 1px solid var(--border);">{{ $cursoDetalle->codigo ?: 'N/A' }}</td>
                                                    <td style="padding: 0.5rem; border: 1px solid var(--border);">{{ $cursoDetalle->nombre }}</td>
                                                    <td style="padding: 0.5rem; border: 1px solid var(--border);">{{ $cursoDetalle->dia }}</td>
                                                    <td style="padding: 0.5rem; border: 1px solid var(--border);">{{ $cursoDetalle->rango_horas }}</td>
                                                    <td style="padding: 0.5rem; border: 1px solid var(--border); text-align: center;">{{ $cursoDetalle->numero_horarios }}</td>
                                                    <td style="padding: 0.5rem; border: 1px solid var(--border); text-align: center;">{{ $cursoDetalle->total_inscripciones }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @else
                                        <p style="color: var(--muted-foreground);">No hay datos de cursos inscritos.</p>
                                    @endif

                                    <h4>Horarios Sin Cupos</h4>
                                    @if(isset($datos['lista_horarios_sin_cupos']) && count($datos['lista_horarios_sin_cupos']) > 0)
                                        <table style="width: 100%; border-collapse: collapse;">
                                            <thead style="background: #f3f4f6;">
                                                <tr>
                                                    <th style="padding: 0.5rem; border: 1px solid var(--border); text-align: left;">Código</th>
                                                    <th style="padding: 0.5rem; border: 1px solid var(--border); text-align: left;">Nombre Curso</th>
                                                    <th style="padding: 0.5rem; border: 1px solid var(--border); text-align: left;">Profesor</th>
                                                    <th style="padding: 0.5rem; border: 1px solid var(--border); text-align: left;">Día</th>
                                                    <th style="padding: 0.5rem; border: 1px solid var(--border); text-align: left;">Rango de Horas</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($datos['lista_horarios_sin_cupos'] as $horarioSinCupo)
                                                <tr>
                                                    <td style="padding: 0.5rem; border: 1px solid var(--border);">{{ $horarioSinCupo->codigo }}</td>
                                                    <td style="padding: 0.5rem; border: 1px solid var(--border);">{{ $horarioSinCupo->nombre_curso }}</td>
                                                    <td style="padding: 0.5rem; border: 1px solid var(--border);">{{ $horarioSinCupo->profesor }}</td>
                                                    <td style="padding: 0.5rem; border: 1px solid var(--border);">{{ $horarioSinCupo->dia }}</td>
                                                    <td style="padding: 0.5rem; border: 1px solid var(--border);">{{ $horarioSinCupo->rango_horas }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @else
                                        <p style="color: var(--muted-foreground);">No hay horarios sin cupos.</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                    @endforeach
                </div>

                <!-- Formulario de Filtros -->
                <form method="GET" action="{{ route('admin.informe.index') }}" class="filter-form">
                    <div class="form-group">
                        <label for="tipo_curso">Tipo de Curso:</label>
                        <select name="tipo_curso" id="tipo_curso" onchange="this.form.submit()">
                            <option value="Deporte formativo" {{ $tipoCurso == 'Deporte formativo' ? 'selected' : '' }}>Deporte formativo</option>
                            <option value="Arte y cultura" {{ $tipoCurso == 'Arte y cultura' ? 'selected' : '' }}>Arte y cultura</option>
                            <option value="Catedra Santiaguina" {{ $tipoCurso == 'Catedra Santiaguina' ? 'selected' : '' }}>Catedra Santiaguina</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="curso_id">Curso Específico:</label>
                        <select name="curso_id" id="curso_id" onchange="this.form.submit()">
                            <option value="todos">Todos los cursos</option>
                            @foreach ($cursosTipo as $curso)
                                <option value="{{ $curso->id }}" {{ (string)$cursoId === (string)$curso->id ? 'selected' : '' }}>
                                    {{ $curso->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="estamento">Estamento:</label>
                        <select name="estamento" id="estamento" onchange="this.form.submit()">
                            <option value="todos" {{ $estamento == 'todos' ? 'selected' : '' }}>Todos</option>
                            <option value="Estudiante" {{ $estamento == 'Estudiante' ? 'selected' : '' }}>Estudiante</option>
                            <option value="Tercero" {{ $estamento == 'Tercero' ? 'selected' : '' }}>Tercero</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="facultad">Facultad:</label>
                        <select name="facultad" id="facultad" onchange="this.form.submit()">
                            <option value="todos" {{ $facultad == 'todos' ? 'selected' : '' }}>Todas las facultades</option>
                            @foreach ($facultades as $fac)
                                <option value="{{ $fac }}" {{ $facultad == $fac ? 'selected' : '' }}>{{ $fac }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="programa">Programa Académico:</label>
                        <select name="programa" id="programa" onchange="this.form.submit()">
                            <option value="todos" {{ $programa == 'todos' ? 'selected' : '' }}>Todos los programas</option>
                            @foreach ($programas as $prog)
                                <option value="{{ $prog }}" {{ $programa == $prog ? 'selected' : '' }}>{{ $prog }}</option>
                            @endforeach
                        </select>
                    </div>

                    <a href="{{ route('admin.informe.index') }}" class="btn-filter" style="background: #f3f4f6; color: #374151; text-decoration: none; border: 1px solid var(--border);">
                        Limpiar Filtros
                    </a>
                </form>

                <!-- Contenedor de la Tabla -->
                <div class="table-container">
                    <table id="informeTable" class="display nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Fecha de Inscripción</th>
                                <th>Nombre Completo</th>
                                <th>Documento</th>
                                <th>Teléfono</th>
                                <th>Correo</th>
                                <th>Estamento</th>
                                <th>Facultad</th>
                                <th>Programa Académico</th>
                                @foreach ($nombresCursos as $columnaCurso)
                                    <th>{{ mb_strtoupper($columnaCurso) }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($estudiantesPivot as $estudiante)
                                <tr>
                                    <td>{{ $estudiante['ID'] }}</td>
                                    <td>{{ $estudiante['Fecha y Hora de inscripcion'] }}</td>
                                    <td>{{ $estudiante['Nombre y Apellidos Completos'] }}</td>
                                    <td>{{ $estudiante['Registre el Número de Documento de identidad'] }}</td>
                                    <td>{{ $estudiante['Teléfono de Contacto'] }}</td>
                                    <td>{{ $estudiante['Correo Electrónico'] }}</td>
                                    <td>{{ $estudiante['Estamento'] }}</td>
                                    <td>{{ $estudiante['Seleccione la Facultad a la cual pertenece'] }}</td>
                                    <td>{{ $estudiante['Selecciona el Programa Académico'] }}</td>
                                    
                                    @foreach ($nombresCursos as $columnaCurso)
                                        <td style="text-align: center; font-weight: bold; color: var(--primary);">
                                            {{ $estudiante[$columnaCurso] }}
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </main>
    </div>

    <!-- Scripts DataTables -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#informeTable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: '<svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2" fill="none" style="vertical-align: middle; margin-right: 5px;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="8" y1="13" x2="16" y2="13"></line><line x1="8" y1="17" x2="16" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg> Descargar Excel',
                        className: 'btn-export-excel',
                        title: function() {
                            let filename = 'Reporte_Inscripciones_' + $('#tipo_curso').val().replace(/ /g, '_');
                            if ($('#curso_id').val() !== 'todos') {
                                filename += '_' + $('#curso_id option:selected').text().trim().replace(/ /g, '_');
                            }
                            if ($('#estamento').val() !== 'todos') {
                                filename += '_' + $('#estamento').val();
                            }
                            if ($('#facultad').val() !== 'todos') {
                                filename += '_' + $('#facultad').val().replace(/ /g, '_');
                            }
                            return filename;
                        }
                    }
                ],
                scrollX: true,
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                }
            });
        });

        function openDetailsModal(id) {
            document.getElementById('detailsModal_' + id).style.display = 'flex';
        }
        function closeDetailsModal(id) {
            document.getElementById('detailsModal_' + id).style.display = 'none';
        }
    </script>
</body>
</html>
