<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="theme-color" content="#0c1381">
    <title>Panel Admin - Informes de Inscripciones</title>
    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style><link rel="stylesheet" href="{{ asset('css/student.css') }}">
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    
    <style>
        :root {
            --primary: #0c1381;
            --primary-hover: #090e63;
            --primary-foreground: #ffffff;
            --foreground: #1f2e2b;
            --muted: #f1f5f9;
            --muted-foreground: #64748b;
            --background: #f8f6f2;
            --card: #ffffff;
            --border: #e2ddd5;
            --radius-md: 0.5rem;
            --radius-lg: 0.75rem;
            --radius-xl: 1rem;
            --radius-full: 9999px;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            --emerald-bg: #dcfce7;
            --emerald-text: #166534;
            --amber-bg: #fef3c7;
            --amber-text: #92400e;
        }

        body { font-family: 'Inter', sans-serif; background-color: var(--background); margin: 0; }
        
        /* ── Layout ── */
        .app-layout { min-height: 100vh; display: flex; flex-direction: column; }
        
        /* ── Header ── */
        .main-header { background: white; border-bottom: 1px solid var(--border); sticky; top: 0; z-index: 50; padding: 1rem 1.5rem; }
        .header-inner { max-width: 80rem; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; }
        
        .logo-link { display: flex; align-items: center; gap: 0.75rem; text-decoration: none; }
        .logo-icon { width: 3.5rem; height: 3.5rem; display: flex; align-items: center; justify-content: center; border-radius: var(--radius-md); }
        .logo-icon img { width: 100%; height: 100%; object-fit: contain; }
        .logo-title { display: block; font-weight: 700; color: var(--foreground); font-size: 1.125rem; }
        .logo-subtitle { display: block; font-size: 0.75rem; color: var(--muted-foreground); font-weight: 500; }
        
        .admin-nav { display: flex; gap: 1.5rem; }
        .nav-link { text-decoration: none; font-size: 0.875rem; transition: all 0.2s; }
        
        .header-actions { display: flex; align-items: center; gap: 1rem; }
        .logout-btn { background: none; border: none; color: var(--muted-foreground); cursor: pointer; padding: 0.5rem; border-radius: var(--radius-md); transition: all 0.2s; }
        .logout-btn:hover { background: var(--muted); color: var(--primary); }
        .logout-btn svg { width: 1.25rem; height: 1.25rem; }

        .main-content { flex: 1; padding: 2rem 1.5rem; }
        .content-container { max-width: 80rem; margin: 0 auto; }

        /* ── Hero ── */
        .hero-section { margin-bottom: 2rem; }
        .hero-section h1 { font-size: 1.875rem; font-weight: 700; color: var(--foreground); margin: 0 0 0.5rem 0; }
        .hero-section p { color: var(--muted-foreground); margin: 0; }

        /* ── Filters ── */
        .filters-card { background: white; padding: 1.5rem; border-radius: var(--radius-lg); border: 1px solid var(--border); margin-bottom: 2rem; box-shadow: var(--shadow-sm); }
        .filters-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; align-items: end; }
        .filter-group { display: flex; flex-direction: column; gap: 0.5rem; }
        .filter-group label { font-size: 0.875rem; font-weight: 600; color: var(--foreground); }
        .filter-group select { padding: 0.625rem; border-radius: var(--radius-md); border: 1px solid var(--border); background: white; font-family: inherit; }
        
        .btn-primary { background: var(--primary); color: white; border: none; padding: 0.625rem 1.25rem; border-radius: var(--radius-md); font-weight: 600; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; justify-content: center; gap: 0.5rem; text-decoration: none; font-size: 0.875rem; }
        .btn-primary:hover { background: var(--primary-hover); transform: translateY(-1px); }

        /* ── Table ── */
        .table-container { background: white; border-radius: var(--radius-lg); border: 1px solid var(--border); overflow: hidden; box-shadow: var(--shadow-sm); }
        .responsive-table { width: 100%; border-collapse: collapse; text-align: left; }
        .responsive-table th { background: #f8fafc; padding: 1rem; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--muted-foreground); border-bottom: 1px solid var(--border); }
        .responsive-table td { padding: 1rem; font-size: 0.875rem; border-bottom: 1px solid var(--border); color: var(--foreground); }
        .responsive-table tr:last-child td { border-bottom: none; }
        .responsive-table tr:hover td { background: #f8fafc; }

        .badge { display: inline-flex; align-items: center; padding: 0.25rem 0.625rem; border-radius: var(--radius-full); font-size: 0.75rem; font-weight: 600; }
        .badge-info { background: #e0f2fe; color: #0369a1; }

        @media (max-width: 768px) {
            .header-inner { flex-direction: column; align-items: flex-start; }
            .admin-nav { width: 100%; border-top: 1px solid var(--border); padding-top: 1rem; }
            .filters-grid { grid-template-columns: 1fr; }
            .responsive-table thead { display: none; }
            .responsive-table tr { display: block; border-bottom: 2px solid var(--border); padding: 1rem 0; }
            .responsive-table td { display: flex; justify-content: space-between; align-items: center; padding: 0.5rem 1rem; border: none; text-align: right; }
            .responsive-table td::before { content: attr(data-label); font-weight: 700; color: var(--muted-foreground); text-transform: uppercase; font-size: 0.75rem; margin-right: 1rem; text-align: left; }
        }
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

            <div class="filters-card">
                <form action="{{ route('admin.informe.index') }}" method="GET" class="filters-grid">
                    <div class="filter-group">
                        <label for="tipo_curso">Tipo de Curso</label>
                        <select name="tipo_curso" id="tipo_curso" onchange="this.form.submit()">
                            <option value="Deporte formativo" {{ $tipoCurso == 'Deporte formativo' ? 'selected' : '' }}>Deporte formativo</option>
                            <option value="Arte y cultura" {{ $tipoCurso == 'Arte y cultura' ? 'selected' : '' }}>Arte y cultura</option>
                            <option value="Catedra Santiaguina" {{ $tipoCurso == 'Catedra Santiaguina' ? 'selected' : '' }}>Catedra Santiaguina</option>
                        </select>
                    </div>

                    <div class="filter-group">
                        <label for="curso_id">Curso Específico</label>
                        <select name="curso_id" id="curso_id" onchange="this.form.submit()">
                            <option value="todos">Todos los cursos</option>
                            @foreach ($cursosTipo as $curso)
                                <option value="{{ $curso->id }}" {{ (string)$cursoId === (string)$curso->id ? 'selected' : '' }}>
                                    {{ $curso->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <a href="{{ url('/admin/informe/generar') }}?tipo_curso={{ $tipoCurso }}&curso_id={{ $cursoId }}" class="btn-primary">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:1.25rem;height:1.25rem;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4m4-5 5 5 5-5m-5 5V3"/></svg>
                        Exportar Excel
                    </a>
                </form>
            </div>

            <div class="table-container">
                <table class="responsive-table">
                    <thead>
                        <tr>
                            <th>Estudiante</th>
                            <th>Identificación</th>
                            <th>Facultad</th>
                            <th>Programa</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($estudiantesPivot as $estudiante)
                            <tr>
                                <td data-label="Estudiante">
                                    <div style="font-weight: 600;">{{ $estudiante['Nombre y Apellidos Completos'] }}</div>
                                </td>
                                <td data-label="Identificación">{{ $estudiante['Registre el Número de Documento de identidad'] }}</td>
                                <td data-label="Facultad">{{ $estudiante['Seleccione la Facultad a la cual pertenece'] }}</td>
                                <td data-label="Programa">{{ $estudiante['Selecciona el Programa Académico'] }}</td>
                                <td data-label="Fecha">{{ $estudiante['Fecha y Hora de inscripcion'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 3rem; color: var(--muted-foreground);">
                                    No se encontraron inscripciones con los filtros seleccionados.
                                </td>
                            </tr>
                        @endforelse
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
