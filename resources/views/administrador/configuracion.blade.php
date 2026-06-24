<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Configuración Global - Bienestar</title>
    <link rel="stylesheet" href="{{ asset('css/student.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .config-container {
            background: white;
            padding: 2rem;
            border-radius: var(--radius-lg);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 2rem auto;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }
        .form-control {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
        }
        .btn-save {
            background: var(--primary);
            color: white;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: var(--radius-md);
            font-weight: 600;
            cursor: pointer;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="app-layout">
        <header class="main-header">
            <div class="header-inner">
                <div class="logo-link">
                    <div class="logo-text">
                        <span class="logo-title">Bienestar USC</span>
                        <span class="logo-subtitle">Panel Administrativo</span>
                    </div>
                </div>
                <nav class="admin-nav" style="display: flex; gap: 1.5rem; margin-left: 2rem;">
                    <a href="{{ route('admin.cursos.index') }}" class="nav-link" style="text-decoration: none; color: var(--muted-foreground); font-weight: 500;">Cursos</a>
                    <a href="{{ route('admin.informe.index') }}" class="nav-link" style="text-decoration: none; color: var(--muted-foreground); font-weight: 500;">Informes</a>
                    <a href="{{ route('admin.configuracion.index') }}" class="nav-link" style="text-decoration: none; color: var(--primary); font-weight: 700; border-bottom: 2px solid var(--primary); padding-bottom: 4px;">Configuración</a>
                </nav>
            </div>
        </header>

        <main class="main-content">
            <div class="content-container">
                <h1 style="text-align: center; margin-top: 2rem;">Configuración Global de Inscripciones</h1>
                
                <div class="config-container">
                    @if(session('success'))
                        <div style="background: #dcfce7; color: #166534; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('admin.configuracion.update') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Estado Global Instantáneo</label>
                            <select name="estado_global_inscripciones" class="form-control">
                                <option value="activo" {{ ($estado->valor ?? '') == 'activo' ? 'selected' : '' }}>Activo (Inscripciones Abiertas)</option>
                                <option value="inactivo" {{ ($estado->valor ?? '') == 'inactivo' ? 'selected' : '' }}>Inactivo (Inscripciones Cerradas)</option>
                            </select>
                            <small style="color: var(--muted-foreground); display:block; margin-top:0.5rem;">
                                Si se marca como "Inactivo", nadie podrá inscribirse sin importar las fechas programadas.
                            </small>
                        </div>

                        <div style="border-top: 1px solid var(--border); margin: 2rem 0;"></div>
                        <h3 style="margin-bottom: 1rem;">Programación por Fechas</h3>

                        <div class="form-group">
                            <label>Fecha de Apertura</label>
                            <input type="datetime-local" name="fecha_inicio_inscripciones" class="form-control" value="{{ $fechaInicio->valor ?? '' }}">
                        </div>

                        <div class="form-group">
                            <label>Fecha de Cierre</label>
                            <input type="datetime-local" name="fecha_fin_inscripciones" class="form-control" value="{{ $fechaFin->valor ?? '' }}">
                        </div>

                        <button type="submit" class="btn-save">Guardar Configuración</button>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
