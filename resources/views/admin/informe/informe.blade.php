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
            padding: 2rem;
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
            min-width: 200px;
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
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                    </div>
                    <div class="logo-text">
                        <span class="logo-title">Bienestar USC</span>
                        <span class="logo-subtitle">Panel Administrativo</span>
                    </div>
                </div>

                <nav class="admin-nav" style="display: flex; gap: 1.5rem; margin-left: 2rem;">
                    <a href="{{ route('admin.cursos.index') }}" class="nav-link {{ request()->routeIs('admin.cursos.index') ? 'active' : '' }}" style="text-decoration: none; color: var(--muted-foreground); font-weight: 500; transition: all 0.2s;">Cursos</a>
                    <a href="{{ route('admin.informe.index') }}" class="nav-link {{ request()->routeIs('admin.informe.index') ? 'active' : '' }}" style="text-decoration: none; color: var(--primary); font-weight: 700; border-bottom: 2px solid var(--primary); padding-bottom: 4px;">Informes</a>
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
                        <p>Genera reportes detallados y descárgalos en Excel organizados por tipo de curso.</p>
                    </div>
                </section>

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
                        <select name="curso_id" id="curso_id">
                            <option value="todos">Todos los cursos</option>
                            @foreach ($cursosTipo as $curso)
                                <option value="{{ $curso->id }}" {{ (string)$cursoId === (string)$curso->id ? 'selected' : '' }}>
                                    {{ $curso->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn-filter">Generar Reporte</button>
                </form>

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
                        title: 'Reporte_Inscripciones_' + $('#tipo_curso').val().replace(/ /g, '_'),
                    }
                ],
                scrollX: true,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                }
            });
        });
    </script>
</body>
</html>
