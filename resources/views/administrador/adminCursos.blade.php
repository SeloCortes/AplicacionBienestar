<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#0c1381">
    <title>Panel Admin - Gestión de Cursos</title>
    <link rel="stylesheet" href="{{ asset('css/student.css') }}">
    {{-- Estilos extra para admin --}}
    <style>
        .admin-controls { display: flex; gap: 0.5rem; margin-top: auto; }
        .btn-edit { background: var(--amber-bg); color: var(--amber-text); padding: 0.5rem; border-radius: var(--radius-md); flex: 1; font-weight: 600; font-size: 0.8rem; }
        .btn-delete { background: #fee2e2; color: #991b1b; padding: 0.5rem; border-radius: var(--radius-md); font-weight: 600; font-size: 0.8rem; }
        .btn-add-course { background: var(--primary); color: white; padding: 0.75rem 1.5rem; border-radius: var(--radius-full); font-weight: 600; display: flex; align-items: center; gap: 0.5rem; box-shadow: 0 4px 12px rgba(12, 19, 129, 0.3); }
        .modal-form-group { display: flex; flex-direction: column; gap: 0.5rem; margin-bottom: 1rem; }
        .modal-form-group label { font-size: 0.875rem; font-weight: 600; color: var(--foreground); }
        .modal-form-group input, .modal-form-group select, .modal-form-group textarea { padding: 0.625rem; border-radius: var(--radius-md); border: 1px solid var(--border); font-family: inherit; }
        .horario-admin-item { border-left: 4px solid var(--primary); }
        .add-horario-form { background: var(--muted); padding: 1rem; border-radius: var(--radius-lg); margin-bottom: 1.5rem; border: 1px dashed var(--border); }
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
                    <a href="{{ route('admin.cursos.index') }}" class="nav-link {{ request()->routeIs('admin.cursos.index') ? 'active' : '' }}" style="text-decoration: none; color: var(--primary); font-weight: 700; border-bottom: 2px solid var(--primary); padding-bottom: 4px;">Cursos</a>
                    <a href="{{ route('admin.informe.index') }}" class="nav-link {{ request()->routeIs('admin.informe.index') ? 'active' : '' }}" style="text-decoration: none; color: var(--muted-foreground); font-weight: 500; transition: all 0.2s;">Informes</a>
                </nav>

                <div class="header-actions">
                    <button type="button" class="btn-add-course" id="btnNewCourse">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width:1.25rem;height:1.25rem;"><path d="M12 5v14M5 12h14"/></svg>
                        Nuevo Curso
                    </button>
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
                        <h1>Gestión de Oferta Académica</h1>
                        <p>Crea cursos, edita información y administra los horarios disponibles para los estudiantes.</p>
                    </div>
                </section>

                <div class="sections-container">
                    @php
                        $grupos = [
                            'Deporte formativo' => ['color' => 'emerald'],
                            'Arte y cultura' => ['color' => 'amber'],
                            'Catedra Santiaguina' => ['color' => 'sky'],
                        ];
                    @endphp

                    @foreach ($grupos as $categoria => $config)
                        <section class="course-section">
                            <header class="section-header">
                                <h2 class="section-title">{{ $categoria }}</h2>
                                <span class="section-count">{{ $cursos->where('tipo_curso', $categoria)->count() }} cursos</span>
                            </header>

                            <div class="courses-grid">
                                @foreach ($cursos->where('tipo_curso', $categoria) as $curso)
                                    <article class="course-card">
                                        <div class="card-image card-image--{{ $config['color'] }}">
                                            @if ($curso->imagen)
                                                <img src="{{ asset($curso->imagen) }}" alt="{{ $curso->nombre }}">
                                            @endif
                                            <span class="card-badge card-badge--{{ $config['color'] }}">{{ $categoria }}</span>
                                        </div>
                                        <div class="card-body">
                                            <h3 class="card-title">{{ $curso->nombre }}</h3>
                                            <p class="card-description">{{ $curso->descripcion }}</p>
                                            <div class="admin-controls">
                                                <button type="button" class="btn-edit btnManageHorarios" data-curso-id="{{ $curso->id }}" data-curso-nombre="{{ $curso->nombre }}">
                                                    Gestionar Horarios
                                                </button>
                                                <button type="button" class="btn-delete" onclick="deleteCourse({{ $curso->id }})">
                                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:1rem;height:1rem;"><path d="M3 6h18m-2 0v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                                </button>
                                            </div>
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        </section>
                    @endforeach
                </div>
            </div>
        </main>
    </div>

    {{-- Modal para Nuevo Curso --}}
    <div id="courseModal" class="modal-overlay" style="display: none;">
        <div class="modal-container">
            <header class="modal-header">
                <h3 class="modal-title">Crear Nuevo Curso</h3>
                <button type="button" class="modal-close" onclick="closeModal('courseModal')"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg></button>
            </header>
            <form id="formNewCourse" class="modal-body">
                @csrf
                <div class="modal-form-group">
                    <label>Nombre del Curso</label>
                    <input type="text" name="nombre" required placeholder="Ej: Karate Do">
                </div>
                <div class="modal-form-group">
                    <label>Categoría</label>
                    <select name="tipo_curso" required>
                        <option value="Deporte formativo">Deporte formativo</option>
                        <option value="Arte y cultura">Arte y cultura</option>
                        <option value="Catedra Santiaguina">Catedra Santiaguina</option>
                    </select>
                </div>
                <div class="modal-form-group">
                    <label>Descripción</label>
                    <textarea name="descripcion" rows="3" placeholder="Breve descripción del curso..."></textarea>
                </div>
                <div class="modal-form-group">
                    <label>URL de Imagen</label>
                    <input type="text" name="imagen" placeholder="Ej: images/cursos/karate.jpg">
                    <small style="font-size: 0.7rem; color: var(--muted-foreground);">Por ahora, ingresa la ruta relativa de la imagen en public/images/</small>
                </div>
                <div class="modal-form-group">
                    <label>Estado Inicial</label>
                    <select name="activo">
                        <option value="1">Activo (Visible para estudiantes)</option>
                        <option value="0">Inactivo (Oculto)</option>
                    </select>
                </div>
                <button type="submit" class="btn-inscribir-horario" style="width:100%; margin-top:1rem;">Guardar Curso</button>
            </form>
        </div>
    </div>

    {{-- Modal para Horarios --}}
    <div id="horariosAdminModal" class="modal-overlay" style="display: none;">
        <div class="modal-container" style="max-width: 40rem;">
            <header class="modal-header">
                <div class="modal-title-group">
                    <h3 id="adminModalCursoNombre" class="modal-title">Gestionar Horarios</h3>
                    <p class="modal-subtitle">Añade o elimina turnos para este curso</p>
                </div>
                <button type="button" class="modal-close" onclick="closeModal('horariosAdminModal')"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg></button>
            </header>
            <div class="modal-body">
                <div class="add-horario-form">
                    <h4 style="font-size:0.9rem; font-weight:700; margin-bottom:1rem;">Añadir Nuevo Horario</h4>
                    <form id="formAddHorario" style="display:grid; grid-template-columns: 1fr 1fr; gap:0.75rem;">
                        @csrf
                        <input type="hidden" name="curso_id" id="currentCursoId">
                        <div class="modal-form-group"><label>Día</label><select name="dia"><option>Lunes</option><option>Martes</option><option>Miércoles</option><option>Jueves</option><option>Viernes</option><option>Sábado</option></select></div>
                        <div class="modal-form-group"><label>Profesor</label><input type="text" name="profesor" placeholder="Nombre prof."></div>
                        <div class="modal-form-group"><label>Hora Inicio</label><input type="time" name="hora_inicio"></div>
                        <div class="modal-form-group"><label>Hora Fin</label><input type="time" name="hora_fin"></div>
                        <div class="modal-form-group"><label>Salón</label><input type="text" name="salon" placeholder="Ej: Salón 1"></div>
                        <div class="modal-form-group"><label>Cupo Estudiantes</label><input type="number" name="cupo_maximo_estudiante" value="20"></div>
                        <div class="modal-form-group"><label>Cupo Terceros</label><input type="number" name="cupo_maximo_tercero" value="5"></div>
                        <button type="submit" class="btn-inscribir-horario" style="grid-column: span 2;">Agregar Horario</button>
                    </form>
                </div>
                <div id="adminHorariosList" class="horarios-list"></div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script>
        function closeModal(id) { document.getElementById(id).style.display = 'none'; }
        
        document.getElementById('btnNewCourse').onclick = () => document.getElementById('courseModal').style.display = 'flex';

        // Lógica para gestionar horarios
        document.querySelectorAll('.btnManageHorarios').forEach(btn => {
            btn.onclick = function() {
                const id = this.dataset.cursoId;
                document.getElementById('currentCursoId').value = id;
                document.getElementById('adminModalCursoNombre').textContent = this.dataset.cursoNombre;
                loadAdminHorarios(id);
                document.getElementById('horariosAdminModal').style.display = 'flex';
            }
        });

        async function loadAdminHorarios(cursoId) {
            const list = document.getElementById('adminHorariosList');
            list.innerHTML = 'Cargando...';
            const res = await fetch(`/cursos/${cursoId}/horarios`);
            const data = await res.json();
            list.innerHTML = '';
            (data.horarios || []).forEach(h => {
                const div = document.createElement('div');
                div.className = 'horario-item horario-admin-item';
                div.innerHTML = `
                    <div class="horario-info">
                        <div class="horario-day-time"><span>${h.dia}</span> | <span>${h.hora_inicio.substring(0,5)} - ${h.hora_fin.substring(0,5)}</span></div>
                        <div class="horario-profesor">Prof. ${h.profesor || 'N/A'} • Salón: ${h.salon || 'N/A'}</div>
                        <div class="horario-profesor" style="font-size: 0.75rem; color: var(--muted-foreground);">Est: ${h.cupo_disponible_estudiante}/${h.cupo_maximo_estudiante} | Ter: ${h.cupo_disponible_tercero}/${h.cupo_maximo_tercero}</div>
                    </div>
                    <button class="btn-delete" onclick="deleteHorario(${h.id}, ${cursoId})">Eliminar</button>
                `;
                list.appendChild(div);
            });
        }

        document.getElementById('formNewCourse').onsubmit = async (e) => {
            e.preventDefault();
            const res = await fetch('/admin/cursos', { method: 'POST', body: new FormData(e.target), headers: { 'Accept': 'application/json' }});
            if(res.ok) location.reload();
        };

        document.getElementById('formAddHorario').onsubmit = async (e) => {
            e.preventDefault();
            const formData = new FormData(e.target);
            formData.append('cupo_disponible_estudiante', formData.get('cupo_maximo_estudiante'));
            formData.append('cupo_disponible_tercero', formData.get('cupo_maximo_tercero'));
            formData.append('activo', 1);
            const res = await fetch('/admin/horarios', { method: 'POST', body: formData, headers: { 'Accept': 'application/json' }});
            if(res.ok) loadAdminHorarios(document.getElementById('currentCursoId').value);
        };

        async function deleteCourse(id) { if(confirm('¿Seguro?')) { await fetch(`/admin/cursos/${id}`, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }}); location.reload(); } }
        async function deleteHorario(id, cursoId) { if(confirm('¿Eliminar horario?')) { await fetch(`/admin/horarios/${id}`, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }}); loadAdminHorarios(cursoId); } }
    </script>
</body>
</html>