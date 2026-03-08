<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#3d8b7a">
    <title>Bienestar USC - Cursos</title>
    <link rel="stylesheet" href="{{ asset('css/student.css') }}">
    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="app-layout">
        {{-- Header --}}
        <header class="main-header">
            <div class="header-inner">
                <a href="{{ url('/cursos') }}" class="logo-link">
                    <div class="logo-icon">
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                        </svg>
                    </div>
                    <div class="logo-text">
                        <span class="logo-title">Bienestar USC</span>
                        <span class="logo-subtitle">Oferta de cursos</span>
                    </div>
                </a>

                <div class="header-actions">
                    <div class="courses-badge">
                        <span class="badge-dot"></span>
                        <span id="totalCursos">{{ $cursos->count() }}</span> cursos
                    </div>
                    <div class="user-badge">
                        <div class="user-avatar">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                        </div>
                        <span>Estudiante</span>
                    </div>
                    <form action="{{ url('/logout') }}" method="POST" class="logout-form">
                        @csrf
                        <button type="submit" class="logout-btn" aria-label="Cerrar sesion">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                                <polyline points="16 17 21 12 16 7"/>
                                <line x1="21" y1="12" x2="9" y2="12"/>
                            </svg>
                            <span>Salir</span>
                        </button>
                    </form>
                </div>
            </div>
        </header>

        {{-- Main --}}
        <main class="main-content">
            <div class="content-container">
                {{-- Hero Section --}}
                <section class="hero-section">
                    <div class="hero-text">
                        <h1>Elige tu curso de bienestar</h1>
                        <p>Explora los cursos disponibles en Deporte formativo, Arte y cultura, y Catedra Santiaguina.</p>
                    </div>
                </section>

                {{-- Filter Tabs --}}
                <div class="filter-tabs" role="tablist">
                    <button type="button" data-filter="all" class="filter-btn active" role="tab" aria-selected="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="3" width="7" height="7" rx="1"/>
                            <rect x="14" y="3" width="7" height="7" rx="1"/>
                            <rect x="3" y="14" width="7" height="7" rx="1"/>
                            <rect x="14" y="14" width="7" height="7" rx="1"/>
                        </svg>
                        <span>Todos</span>
                        <span class="filter-count">{{ $cursos->count() }}</span>
                    </button>
                    <button type="button" data-filter="Deporte formativo" class="filter-btn" role="tab" aria-selected="false">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <path d="m4.93 4.93 4.24 4.24"/>
                            <path d="m14.83 9.17 4.24-4.24"/>
                            <path d="m14.83 14.83 4.24 4.24"/>
                            <path d="m9.17 14.83-4.24 4.24"/>
                            <circle cx="12" cy="12" r="4"/>
                        </svg>
                        <span>Deporte</span>
                        <span class="filter-count">{{ $cursos->where('tipo_curso', 'Deporte formativo')->count() }}</span>
                    </button>
                    <button type="button" data-filter="Arte y cultura" class="filter-btn" role="tab" aria-selected="false">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 2v4"/>
                            <path d="m6.8 14-3.5 2"/>
                            <path d="m20.7 16-3.5-2"/>
                            <path d="m6.8 10-3.5-2"/>
                            <path d="m20.7 8-3.5 2"/>
                            <circle cx="12" cy="12" r="6"/>
                        </svg>
                        <span>Arte y Cultura</span>
                        <span class="filter-count">{{ $cursos->where('tipo_curso', 'Arte y cultura')->count() }}</span>
                    </button>
                    <button type="button" data-filter="Catedra Santiaguina" class="filter-btn" role="tab" aria-selected="false">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"/>
                            <path d="M8 7h6"/>
                            <path d="M8 11h8"/>
                        </svg>
                        <span>Catedra</span>
                        <span class="filter-count">{{ $cursos->where('tipo_curso', 'Catedra Santiaguina')->count() }}</span>
                    </button>
                </div>

                {{-- Course Sections --}}
                <div id="courseSections" class="sections-container">
                    @php
                        $grupos = [
                            'Deporte formativo' => ['color' => 'emerald', 'icon' => 'sport'],
                            'Arte y cultura' => ['color' => 'amber', 'icon' => 'art'],
                            'Catedra Santiaguina' => ['color' => 'sky', 'icon' => 'book'],
                        ];
                    @endphp

                    @foreach ($grupos as $categoria => $config)
                        @php
                            $cursosGrupo = $cursos->where('tipo_curso', $categoria);
                        @endphp

                        @if ($cursosGrupo->isNotEmpty())
                            <section class="course-section" data-category="{{ $categoria }}">
                                <header class="section-header">
                                    <div class="section-icon section-icon--{{ $config['color'] }}">
                                        @if ($config['icon'] === 'sport')
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <circle cx="12" cy="12" r="10"/>
                                                <path d="m4.93 4.93 4.24 4.24"/>
                                                <path d="m14.83 9.17 4.24-4.24"/>
                                                <path d="m14.83 14.83 4.24 4.24"/>
                                                <path d="m9.17 14.83-4.24 4.24"/>
                                                <circle cx="12" cy="12" r="4"/>
                                            </svg>
                                        @elseif ($config['icon'] === 'art')
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <circle cx="13.5" cy="6.5" r=".5" fill="currentColor"/>
                                                <circle cx="17.5" cy="10.5" r=".5" fill="currentColor"/>
                                                <circle cx="8.5" cy="7.5" r=".5" fill="currentColor"/>
                                                <circle cx="6.5" cy="12.5" r=".5" fill="currentColor"/>
                                                <path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.555-2.503 5.555-5.555C21.965 6.012 17.461 2 12 2z"/>
                                            </svg>
                                        @else
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"/>
                                                <path d="M8 7h6"/>
                                                <path d="M8 11h8"/>
                                            </svg>
                                        @endif
                                    </div>
                                    <div class="section-title-group">
                                        <h2 class="section-title">{{ $categoria }}</h2>
                                        <span class="section-count">{{ $cursosGrupo->count() }} curso{{ $cursosGrupo->count() !== 1 ? 's' : '' }}</span>
                                    </div>
                                </header>

                                <div class="courses-grid">
                                    @foreach ($cursosGrupo as $curso)
                                        <article class="course-card" data-category="{{ $categoria }}">
                                            <div class="card-image card-image--{{ $config['color'] }}">
                                                @if ($curso->imagen)
                                                    <img src="{{ asset($curso->imagen) }}" alt="{{ $curso->nombre }}" loading="lazy">
                                                @else
                                                    <div class="card-placeholder">
                                                        @if ($config['icon'] === 'sport')
                                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                                                <circle cx="12" cy="12" r="10"/>
                                                                <path d="m4.93 4.93 4.24 4.24"/>
                                                                <path d="m14.83 9.17 4.24-4.24"/>
                                                                <path d="m14.83 14.83 4.24 4.24"/>
                                                                <path d="m9.17 14.83-4.24 4.24"/>
                                                                <circle cx="12" cy="12" r="4"/>
                                                            </svg>
                                                        @elseif ($config['icon'] === 'art')
                                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                                                <circle cx="13.5" cy="6.5" r=".5" fill="currentColor"/>
                                                                <circle cx="17.5" cy="10.5" r=".5" fill="currentColor"/>
                                                                <circle cx="8.5" cy="7.5" r=".5" fill="currentColor"/>
                                                                <circle cx="6.5" cy="12.5" r=".5" fill="currentColor"/>
                                                                <path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.555-2.503 5.555-5.555C21.965 6.012 17.461 2 12 2z"/>
                                                            </svg>
                                                        @else
                                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                                                <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"/>
                                                                <path d="M8 7h6"/>
                                                                <path d="M8 11h8"/>
                                                            </svg>
                                                        @endif
                                                    </div>
                                                @endif
                                                <span class="card-badge card-badge--{{ $config['color'] }}">{{ $categoria }}</span>
                                            </div>
                                            <div class="card-body">
                                                <h3 class="card-title">{{ $curso->nombre }}</h3>
                                                @if ($curso->descripcion)
                                                    <p class="card-description">{{ $curso->descripcion }}</p>
                                                @endif
                                                <div class="card-actions">
                                                    <button type="button" class="btn-inscribir" data-curso-id="{{ $curso->id }}">
                                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                            <path d="M12 5v14"/>
                                                            <path d="M5 12h14"/>
                                                        </svg>
                                                        <span>Inscribirse</span>
                                                    </button>
                                                    <button type="button" class="btn-info" data-curso-id="{{ $curso->id }}" aria-label="Ver detalles">
                                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                            <circle cx="12" cy="12" r="10"/>
                                                            <path d="M12 16v-4"/>
                                                            <path d="M12 8h.01"/>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </article>
                                    @endforeach
                                </div>
                            </section>
                        @endif
                    @endforeach
                </div>

                {{-- Empty State --}}
                <div id="emptyState" class="empty-state" style="display: none;">
                    <div class="empty-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <circle cx="11" cy="11" r="8"/>
                            <path d="m21 21-4.3-4.3"/>
                        </svg>
                    </div>
                    <h3>No hay cursos en esta categoria</h3>
                    <p>Intenta seleccionar otra categoria</p>
                </div>
            </div>
        </main>

        {{-- Footer --}}
        <footer class="main-footer">
            <div class="footer-inner">
                <p>Universidad Santiago de Cali - Bienestar Universitario</p>
                <div class="footer-links">
                    <a href="#">Ayuda</a>
                    <a href="#">Contacto</a>
                </div>
            </div>
        </footer>

        {{-- Modal de Horarios --}}
        <div id="horariosModal" class="modal-overlay" style="display: none;">
            <div class="modal-container">
                <header class="modal-header">
                    <div class="modal-title-group">
                        <h3 id="modalCursoNombre" class="modal-title">Horarios Disponibles</h3>
                        <p id="modalCursoCategoria" class="modal-subtitle"></p>
                    </div>
                    <button type="button" class="modal-close" id="closeModal">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M18 6L6 18M6 6l12 12"/>
                        </svg>
                    </button>
                </header>
                
                <div class="modal-body">
                    <div id="modalLoading" class="modal-loading">
                        <div class="spinner"></div>
                        <span>Cargando horarios...</span>
                    </div>
                    
                    <div id="modalError" class="modal-error" style="display: none;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="12" y1="8" x2="12" y2="12"/>
                            <line x1="12" y1="16" x2="12.01" y2="16"/>
                        </svg>
                        <p>No se pudieron cargar los horarios. Intenta de nuevo.</p>
                    </div>

                    <div id="horariosList" class="horarios-list">
                        {{-- Se llena con JS --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script>
        // ── Debug Info ──
        console.log("Cursos cargados desde Laravel:", {{ $cursos->count() }});
        
        // ── GSAP Animations ──
        document.addEventListener('DOMContentLoaded', () => {
            // ELIMINAMOS cualquier opacidad previa para que se vean sí o sí
            gsap.set(".course-card, .section-header, .hero-section, .filter-btn", { 
                opacity: 1, 
                visibility: "visible",
                y: 0,
                x: 0
            });

            const tl = gsap.timeline({
                defaults: { ease: "power2.out" }
            });

            // Animamos DESDE valores invisibles HACIA los visibles (from)
            tl.from(".main-header", {
                yPercent: -100,
                duration: 0.8
            });

            tl.from(".hero-section", {
                opacity: 0,
                y: 20,
                duration: 0.6
            }, "-=0.4");

            tl.from(".filter-btn", {
                opacity: 0,
                y: 10,
                stagger: 0.03,
                duration: 0.4
            }, "-=0.3");

            if (document.querySelectorAll(".course-card").length > 0) {
                tl.from(".section-header", {
                    opacity: 0,
                    x: -15,
                    stagger: 0.1,
                    duration: 0.4
                }, "-=0.2");

                tl.from(".course-card", {
                    opacity: 0,
                    y: 20,
                    stagger: 0.03,
                    duration: 0.5
                }, "-=0.3");
            }
        });

        // ── Filter Functionality ──
        const filterBtns = document.querySelectorAll('.filter-btn');
        const sections = document.querySelectorAll('.course-section');
        const cards = document.querySelectorAll('.course-card');
        const emptyState = document.getElementById('emptyState');

        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const filter = btn.dataset.filter;

                // Update active button
                filterBtns.forEach(b => {
                    b.classList.remove('active');
                    b.setAttribute('aria-selected', 'false');
                });
                btn.classList.add('active');
                btn.setAttribute('aria-selected', 'true');

                // Filter sections
                let visibleCount = 0;

                if (filter === 'all') {
                    sections.forEach(section => {
                        section.style.display = '';
                        visibleCount++;
                    });
                } else {
                    sections.forEach(section => {
                        if (section.dataset.category === filter) {
                            section.style.display = '';
                            visibleCount++;
                        } else {
                            section.style.display = 'none';
                        }
                    });
                }

                // Show/hide empty state
                if (visibleCount === 0) {
                    emptyState.style.display = 'flex';
                    gsap.from(emptyState, { opacity: 0, y: 20, duration: 0.4 });
                } else {
                    emptyState.style.display = 'none';
                }

                // Animate visible cards
                const visibleCards = filter === 'all' 
                    ? '.course-card' 
                    : `.course-section[data-category="${filter}"] .course-card`;
                
                gsap.fromTo(visibleCards,
                    { opacity: 0, y: 25 },
                    { opacity: 1, y: 0, duration: 0.4, stagger: 0.06, ease: "power2.out" }
                );
            });
        });

        // ── Button interactions ──
        const modal = document.getElementById('horariosModal');
        const closeModalBtn = document.getElementById('closeModal');
        const horariosList = document.getElementById('horariosList');
        const modalLoading = document.getElementById('modalLoading');
        const modalError = document.getElementById('modalError');
        const modalCursoNombre = document.getElementById('modalCursoNombre');
        const modalCursoCategoria = document.getElementById('modalCursoCategoria');

        function openModal(cursoId, cursoNombre, cursoCategoria) {
            modalCursoNombre.textContent = cursoNombre;
            modalCursoCategoria.textContent = cursoCategoria;
            modal.style.display = 'flex';
            horariosList.innerHTML = '';
            modalLoading.style.display = 'flex';
            modalError.style.display = 'none';

            // Cargar horarios vía AJAX (usando la ruta que ya tienes)
            fetch(`/cursos/${cursoId}/horarios`, {
                headers: { 'Accept': 'application/json' }
            })
            .then(res => res.json())
            .then(data => {
                modalLoading.style.display = 'none';
                
                // La respuesta del controlador CursosController@horarios trae el objeto curso con sus horarios
                const horarios = data.horarios || [];
                
                if (horarios.length === 0) {
                    horariosList.innerHTML = '<p class="text-center text-slate-500 py-4">No hay horarios disponibles para este curso.</p>';
                    return;
                }

                horarios.forEach(h => {
                    const isFull = h.cupo_disponible <= 0;
                    const item = document.createElement('div');
                    item.className = 'horario-item';
                    item.innerHTML = `
                        <div class="horario-info">
                            <div class="horario-day-time">
                                <span>${h.dia}</span>
                                <span class="text-slate-300">|</span>
                                <span>${h.hora_inicio.substring(0,5)} - ${h.hora_fin.substring(0,5)}</span>
                            </div>
                            <div class="horario-profesor">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="w-3.5 h-3.5">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                                </svg>
                                <span>Prof. ${h.profesor || 'Por asignar'}</span>
                            </div>
                            <span class="horario-cupos ${isFull ? 'horario-cupos--full' : 'horario-cupos--available'}">
                                ${h.cupo_disponible} cupos disponibles
                            </span>
                        </div>
                        <button type="button" 
                                class="btn-inscribir-horario" 
                                data-horario-id="${h.id}"
                                ${isFull ? 'disabled' : ''}>
                            ${isFull ? 'Agotado' : 'Inscribirme'}
                        </button>
                    `;
                    horariosList.appendChild(item);
                });

                // Evento para los botones de inscripción dentro del modal
                horariosList.querySelectorAll('.btn-inscribir-horario').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const hId = this.dataset.horarioId;
                        inscribirEstudiante(hId, this);
                    });
                });
            })
            .catch(err => {
                console.error(err);
                modalLoading.style.display = 'none';
                modalError.style.display = 'flex';
            });
        }

        function closeModal() {
            modal.style.display = 'none';
        }

        closeModalBtn.addEventListener('click', closeModal);
        window.addEventListener('click', (e) => {
            if (e.target === modal) closeModal();
        });

        // Función para procesar la inscripción
        async function inscribirEstudiante(horarioId, btnElement) {
            const originalText = btnElement.textContent;
            btnElement.disabled = true;
            btnElement.textContent = 'Procesando...';

            try {
                const response = await fetch('/inscripcion', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        horario_id: horarioId,
                        user_id: {{ Auth::id() }} // Pasamos el ID del usuario logueado
                    })
                });

                const data = await response.json();

                if (response.ok) {
                    alert('¡Inscripción exitosa!');
                    location.reload(); // Recargamos para actualizar cupos
                } else {
                    alert(data.message || 'Error al inscribirse');
                    btnElement.disabled = false;
                    btnElement.textContent = originalText;
                }
            } catch (error) {
                console.error(error);
                alert('Error de conexión');
                btnElement.disabled = false;
                btnElement.textContent = originalText;
            }
        }

        document.querySelectorAll('.btn-inscribir').forEach(btn => {
            btn.addEventListener('click', function() {
                const cursoId = this.dataset.cursoId;
                const cursoCard = this.closest('.course-card');
                const cursoNombre = cursoCard.querySelector('.card-title').textContent;
                const cursoCategoria = cursoCard.querySelector('.card-badge').textContent;

                // Animacion de feedback
                gsap.to(this, { scale: 0.95, duration: 0.1, yoyo: true, repeat: 1 });
                
                // Abrir el modal con los datos
                openModal(cursoId, cursoNombre, cursoCategoria);
            });
        });

        document.querySelectorAll('.btn-info').forEach(btn => {
            btn.addEventListener('click', function() {
                const cursoId = this.dataset.cursoId;
                gsap.to(this, { scale: 0.9, duration: 0.1, yoyo: true, repeat: 1 });
                // Tu logica de ver detalles aqui
                // window.location.href = `/cursos/${cursoId}`;
            });
        });
    </script>
</body>
</html>