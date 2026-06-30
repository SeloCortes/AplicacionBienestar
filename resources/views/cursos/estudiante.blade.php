<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="theme-color" content="#3d8b7a">
    <title>SISTEMA DE INSCRIPCION DE BIENESTAR UNIVERSITARIO - SIBIU - Cursos</title>
    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="{{ asset('css/student.css') }}">
    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@500;600;700&family=Inter:wght@400;500;600&display=swap"
        rel="stylesheet">
    {{-- Driver.js para el Tour Guiado --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/driver.js@1.0.1/dist/driver.css"/>
</head>

<body>
    <div class="app-layout">
        {{-- Header --}}
        <header class="main-header">
            <div class="header-inner">
                <a href="{{ url('/cursos') }}" class="logo-link">
                    <div class="logo-icon">
                        <img src="{{ asset('images/Logo_Universidad-Santiago-de-Cali.png') }}" alt="Logo USC">
                    </div>
                    <div class="logo-text">
                        <span class="logo-title">SISTEMA DE INSCRIPCION DE BIENESTAR UNIVERSITARIO - SIBIU</span>
                        <span class="logo-subtitle">Bienestar USC</span>
                    </div>
                </a>

                <nav class="student-nav" style="display: flex; gap: 1.5rem; margin-left: 2rem;">
                    <a href="{{ route('cursos.index') }}" class="nav-link active"
                        style="text-decoration: none; color: var(--primary); font-weight: 700; border-bottom: 2px solid var(--primary); padding-bottom: 4px;">Explorar
                        Cursos</a>
                    <a href="{{ route('cursos.mis-cursos') }}" class="nav-link"
                        style="text-decoration: none; color: var(--muted-foreground); font-weight: 500; transition: all 0.2s;">Mis
                        Cursos</a>
                </nav>

                <div class="header-actions">
                    <div class="courses-badge">
                        <span class="badge-dot"></span>
                        <span id="totalCursos">{{ $cursos->count() }}</span> cursos
                    </div>
                    <div class="user-badge">
                        <div class="user-avatar">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                <circle cx="12" cy="7" r="4" />
                            </svg>
                        </div>
                        <span>{{ auth()->user()->nombre_apellido }}</span>
                    </div>
                    <form action="{{ url('/logout') }}" method="POST" class="logout-form">
                        @csrf
                        <button type="submit" class="logout-btn" aria-label="Cerrar sesion">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                <polyline points="16 17 21 12 16 7" />
                                <line x1="21" y1="12" x2="9" y2="12" />
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
                        <p>Explora los cursos disponibles en Deporte formativo, Arte y cultura, y Catedra Santiaguina.
                        </p>
                    </div>
                </section>

                {{-- Filter Tabs --}}
                @if(isset($inscripcionesAbiertas) && !$inscripcionesAbiertas)
                <div style="background: #fee2e2; color: #b91c1c; padding: 1rem; border-radius: var(--radius-md); text-align: center; margin-bottom: 2rem; font-weight: 600; border: 1px solid #fca5a5;">
                    Las inscripciones y cancelaciones se encuentran cerradas en este momento.
                </div>
                @endif
                
                <div class="filter-tabs" role="tablist">
                    <button type="button" data-filter="all" class="filter-btn active" role="tab" aria-selected="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="3" width="7" height="7" rx="1" />
                            <rect x="14" y="3" width="7" height="7" rx="1" />
                            <rect x="3" y="14" width="7" height="7" rx="1" />
                            <rect x="14" y="14" width="7" height="7" rx="1" />
                        </svg>
                        <span>Todos</span>
                        <span class="filter-count">{{ $cursos->count() }}</span>
                    </button>
                    <button type="button" data-filter="Deporte formativo" class="filter-btn" role="tab"
                        aria-selected="false">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10" />
                            <path d="m4.93 4.93 4.24 4.24" />
                            <path d="m14.83 9.17 4.24-4.24" />
                            <path d="m14.83 14.83 4.24 4.24" />
                            <path d="m9.17 14.83-4.24 4.24" />
                            <circle cx="12" cy="12" r="4" />
                        </svg>
                        <span>Deporte</span>
                        <span
                            class="filter-count">{{ $cursos->where('tipo_curso', 'Deporte formativo')->count() }}</span>
                    </button>
                    <button type="button" data-filter="Arte y cultura" class="filter-btn" role="tab"
                        aria-selected="false">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 2v4" />
                            <path d="m6.8 14-3.5 2" />
                            <path d="m20.7 16-3.5-2" />
                            <path d="m6.8 10-3.5-2" />
                            <path d="m20.7 8-3.5 2" />
                            <circle cx="12" cy="12" r="6" />
                        </svg>
                        <span>Arte y Cultura</span>
                        <span class="filter-count">{{ $cursos->where('tipo_curso', 'Arte y cultura')->count() }}</span>
                    </button>
                    <button type="button" data-filter="Catedra Santiaguina" class="filter-btn" role="tab"
                        aria-selected="false">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20" />
                            <path d="M8 7h6" />
                            <path d="M8 11h8" />
                        </svg>
                        <span>Catedra</span>
                        <span
                            class="filter-count">{{ $cursos->where('tipo_curso', 'Catedra Santiaguina')->count() }}</span>
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
                                                <circle cx="12" cy="12" r="10" />
                                                <path d="m4.93 4.93 4.24 4.24" />
                                                <path d="m14.83 9.17 4.24-4.24" />
                                                <path d="m14.83 14.83 4.24 4.24" />
                                                <path d="m9.17 14.83-4.24 4.24" />
                                                <circle cx="12" cy="12" r="4" />
                                            </svg>
                                        @elseif ($config['icon'] === 'art')
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <circle cx="13.5" cy="6.5" r=".5" fill="currentColor" />
                                                <circle cx="17.5" cy="10.5" r=".5" fill="currentColor" />
                                                <circle cx="8.5" cy="7.5" r=".5" fill="currentColor" />
                                                <circle cx="6.5" cy="12.5" r=".5" fill="currentColor" />
                                                <path
                                                    d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.555-2.503 5.555-5.555C21.965 6.012 17.461 2 12 2z" />
                                            </svg>
                                        @else
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20" />
                                                <path d="M8 7h6" />
                                                <path d="M8 11h8" />
                                            </svg>
                                        @endif
                                    </div>
                                    <div class="section-title-group">
                                        <h2 class="section-title">{{ $categoria }}</h2>
                                        <span class="section-count">{{ $cursosGrupo->count() }}
                                            curso{{ $cursosGrupo->count() !== 1 ? 's' : '' }}</span>
                                    </div>
                                </header>

                                <div class="courses-grid">
                                    @foreach ($cursosGrupo as $curso)
                                        @php
                                            $inscritoEnEste = false;
                                            $inscritoEnCategoria = false;
                                            foreach($userInscriptions as $ins) {
                                                if($ins->horario && $ins->horario->curso) {
                                                    if($ins->horario->curso->id === $curso->id) {
                                                        $inscritoEnEste = true;
                                                    }
                                                    if($ins->horario->curso->tipo_curso === $categoria) {
                                                        $inscritoEnCategoria = true;
                                                    }
                                                }
                                            }
                                        @endphp
                                        <article class="course-card" data-category="{{ $categoria }}">
                                            <div class="card-image card-image--{{ $config['color'] }}">
                                                @if ($curso->imagen)
                                                    <img src="{{ asset($curso->imagen) }}" alt="{{ $curso->nombre }}" loading="lazy">
                                                @else
                                                    <div class="card-placeholder">
                                                        @if ($config['icon'] === 'sport')
                                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                                                <circle cx="12" cy="12" r="10" />
                                                                <path d="m4.93 4.93 4.24 4.24" />
                                                                <path d="m14.83 9.17 4.24-4.24" />
                                                                <path d="m14.83 14.83 4.24 4.24" />
                                                                <path d="m9.17 14.83-4.24 4.24" />
                                                                <circle cx="12" cy="12" r="4" />
                                                            </svg>
                                                        @elseif ($config['icon'] === 'art')
                                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                                                <circle cx="13.5" cy="6.5" r=".5" fill="currentColor" />
                                                                <circle cx="17.5" cy="10.5" r=".5" fill="currentColor" />
                                                                <circle cx="8.5" cy="7.5" r=".5" fill="currentColor" />
                                                                <circle cx="6.5" cy="12.5" r=".5" fill="currentColor" />
                                                                <path
                                                                    d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.555-2.503 5.555-5.555C21.965 6.012 17.461 2 12 2z" />
                                                            </svg>
                                                        @else
                                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                                                <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20" />
                                                                <path d="M8 7h6" />
                                                                <path d="M8 11h8" />
                                                            </svg>
                                                        @endif
                                                    </div>
                                                @endif
                                                <span class="card-badge card-badge--{{ $config['color'] }}">{{ $categoria }}</span>
                                            </div>
                                            <div class="card-body">
                                                <h3 class="card-title">{{ $curso->nombre }} @if($curso->codigo) <span style="font-size:0.75em;color:var(--muted-foreground)">({{ $curso->codigo }})</span> @endif</h3>
                                                @if ($curso->descripcion)
                                                    <p class="card-description">{{ $curso->descripcion }}</p>
                                                @endif
                                                <div class="card-actions">
                                                    <button type="button" class="btn-inscribir" data-curso-id="{{ $curso->id }}"
                                                        {{ ($inscritoEnCategoria && !$inscritoEnEste) ? 'disabled style=opacity:0.5;cursor:not-allowed;' : '' }}>
                                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                            @if($inscritoEnEste)
                                                                <path d="M20 6L9 17l-5-5"/>
                                                            @else
                                                                <path d="M12 5v14" />
                                                                <path d="M5 12h14" />
                                                            @endif
                                                        </svg>
                                                        <span>{{ $inscritoEnEste ? 'Inscrito' : ($inscritoEnCategoria ? 'Inscrito en otro curso' : 'Ver horarios') }}</span>
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
                            <circle cx="11" cy="11" r="8" />
                            <path d="m21 21-4.3-4.3" />
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
                            <path d="M18 6L6 18M6 6l12 12" />
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
                            <circle cx="12" cy="12" r="10" />
                            <line x1="12" y1="8" x2="12" y2="12" />
                            <line x1="12" y1="16" x2="12.01" y2="16" />
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

    <script>
        // Pasar inscripciones del usuario a JS
        const userInscriptions = @json($userInscriptions);
        const inscripcionesAbiertas = @json($inscripcionesAbiertas ?? true);
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    {{-- Driver.js Script --}}
    <script src="https://cdn.jsdelivr.net/npm/driver.js@1.0.1/dist/driver.js.iife.js"></script>
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
                }, "-=0.3").add(() => {
                    // Iniciar el tour después de que las animaciones terminen
                    startOnboardingTour();
                });
            }
        });

        // ── Onboarding Tour (Vista Guiada) ──
        function startOnboardingTour() {
            // Solo mostrar el tour si es la primera vez (opcional, usando localStorage)
            if (localStorage.getItem('onboarding_completed')) return;

            const driver = window.driver.js.driver;
            const driverObj = driver({
                showProgress: true,
                nextBtnText: 'Siguiente',
                prevBtnText: 'Anterior',
                doneBtnText: 'Finalizar',
                steps: [
                    { 
                        element: '.logo-link', 
                        popover: { 
                            title: 'SIBIU', 
                            description: 'Bienvenido al Sistema de Inscripción de Bienestar Universitario - SIBIU. Aquí podrás inscribirte a tus cursos favoritos.', 
                            side: "bottom", 
                            align: 'start' 
                        } 
                    },
                    { 
                        element: '.filter-tabs', 
                        popover: { 
                            title: 'Filtra tus intereses', 
                            description: 'Usa estas pestañas para ver solo los cursos de Deporte, Arte o Cátedra.', 
                            side: "bottom", 
                            align: 'center' 
                        } 
                    },
                    { 
                        element: '.course-card', 
                        popover: { 
                            title: 'Cursos Disponibles', 
                            description: 'Cada tarjeta muestra la información del curso. Haz clic en el botón para ver los horarios.', 
                            side: "top", 
                            align: 'center' 
                        } 
                    },
                    { 
                        element: '.user-badge', 
                        popover: { 
                            title: 'Tu Perfil', 
                            description: 'Aquí puedes confirmar que has ingresado con tu cuenta.', 
                            side: "bottom", 
                            align: 'end' 
                        } 
                    },
                    { 
                        element: '.logout-btn', 
                        popover: { 
                            title: 'Cerrar Sesión', 
                            description: 'Cuando termines, no olvides cerrar tu sesión por seguridad.', 
                            side: "bottom", 
                            align: 'end' 
                        } 
                    }
                ],
                onDestroyed: () => {
                    localStorage.setItem('onboarding_completed', 'true');
                }
            });

            driverObj.drive();
        }

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

        function openModal(cursoId, cursoNombre, cursoCategoria, cursoCodigo) {
            document.body.style.overflow = 'hidden'; // Bloquear scroll del fondo
            modalCursoNombre.textContent = cursoNombre + (cursoCodigo ? ` (${cursoCodigo})` : '');
            modalCursoCategoria.textContent = cursoCategoria;
            modal.style.display = 'flex';
            horariosList.innerHTML = '';
            modalLoading.style.display = 'flex';
            modalError.style.display = 'none';

            // Cargar horarios vía AJAX
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

                    // Crear el HTML para cada horario
                    horarios.forEach(h => {
                        // Verificar si el horario no tiene cupos disponibles
                        const isFull = h.cupo_disponible <= 0;
                        // Verificar si el usuario ya esta inscrito en ESTE horario
                        const userEnrollment = userInscriptions.find(ins => ins.horario_id === h.id);
                        // Si el usuario ya esta inscrito en ESTE horario
                        const isEnrolledInThis = !!userEnrollment;

                        // Verificar si el usuario ya esta inscrito en OTRO curso de esta misma categoría
                        const enrollmentInCategory = userInscriptions.find(ins =>
                            ins.horario && ins.horario.curso && ins.horario.curso.tipo_curso === cursoCategoria && ins.horario_id !== h.id
                        );

                        // Crear el item del horario
                        const item = document.createElement('div');
                        item.className = 'horario-item';

                        // Crear el botón de acción
                        let buttonHtml = '';
                        if (isEnrolledInThis) {
                            buttonHtml = `
                                <button type="button" 
                                        class="btn-desinscribir-horario" 
                                        data-inscripcion-id="${userEnrollment.id}"
                                        ${!inscripcionesAbiertas ? 'disabled style="opacity:0.5;cursor:not-allowed;" title="Cancelaciones cerradas"' : ''}>
                                    Desinscribirme
                                </button>
                            `;
                        } else {
                            let disabledReason = '';
                            if (!inscripcionesAbiertas) {
                                disabledReason = 'Inscripciones cerradas';
                            } else if (h.activo == 0 || h.activo === false || h.activo === "0") {
                                disabledReason = 'Horario cerrado';
                            } else if (isFull) {
                                disabledReason = 'Agotado';
                            } else if (enrollmentInCategory) {
                                disabledReason = `Inscrito en otro horario`;
                            }

                            buttonHtml = `
                                <button type="button" 
                                        class="btn-inscribir-horario" 
                                        data-horario-id="${h.id}"
                                        ${disabledReason ? 'disabled' : ''}>
                                    ${disabledReason || 'Inscribirme'}
                                </button>
                            `;
                        }

                        item.innerHTML = `
                        <div class="horario-info">
                            <div class="horario-day-time">
                                <span>${h.dia}</span>
                                <span class="text-slate-300">|</span>
                                <span>${h.hora_inicio.substring(0, 5)} - ${h.hora_fin.substring(0, 5)}</span>
                            </div>
                             <div class="horario-profesor">
                                 <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="w-3.5 h-3.5">
                                     <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                                 </svg>
                                 <span>Salón: ${h.salon || 'N/A'} |  Prof. ${h.profesor || 'Por asignar'}</span>
                             </div>
                            <span class="horario-cupos ${isFull ? 'horario-cupos--full' : 'horario-cupos--available'}">${h.cupo_disponible + ' cupos disponibles'}</span>
                        </div>
                        ${buttonHtml}
                    `;
                        horariosList.appendChild(item);
                    });

                    // Evento para los botones de inscripción dentro del modal
                    horariosList.querySelectorAll('.btn-inscribir-horario').forEach(btn => {
                        btn.addEventListener('click', function () {
                            const hId = this.dataset.horarioId;
                            inscribirEstudiante(hId, this);
                        });
                    });

                    // Evento para los botones de desinscripción
                    horariosList.querySelectorAll('.btn-desinscribir-horario').forEach(btn => {
                        btn.addEventListener('click', function () {
                            const insId = this.dataset.inscripcionId;
                            desinscribirEstudiante(insId, this);
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
            document.body.style.overflow = ''; // Restaurar scroll del fondo
        }

        closeModalBtn.addEventListener('click', closeModal);
        window.addEventListener('click', (e) => {
            if (e.target === modal) closeModal();
        });

        // Función para procesar la inscripción
        async function inscribirEstudiante(horarioId, btnElement) {
            // Alerta de confirmación con advertencia de horario académico
            const result = await Swal.fire({
                title: '¿Confirmar inscripción?',
                text: 'Asegúrate de que este horario no se cruce con tus clases de la carrera (pregrado o posgrado).',
                icon: 'warning',
                showCancelButton: true,
                showCloseButton: true, // Añade la X para cerrar
                confirmButtonColor: '#0c1381',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Sí, inscribirme',
                cancelButtonText: 'Revisar horario académico',
                heightAuto: false
            });

            if (result.dismiss === Swal.DismissReason.cancel) {
                // Si le da a "Revisar horario académico", abrir SINU en pestaña nueva
                window.open('https://sinu.usc.edu.co:8443/sinugwt/', '_blank');
                return;
            }

            if (!result.isConfirmed) return;

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
                        user_id: {{ auth()->id() }}
                    })
                });

                const data = await response.json();

                if (response.ok) {
                    await Swal.fire({
                        title: '¡Inscripción exitosa!',
                        text: 'Te has inscrito correctamente al curso.',
                        icon: 'success',
                        confirmButtonColor: '#0c1381',
                        heightAuto: false
                    });
                    location.reload();
                } else if (response.status === 429) {
                    Swal.fire({
                        title: 'Espera un momento',
                        text: data.message,
                        icon: 'info',
                        confirmButtonColor: '#0c1381',
                        heightAuto: false
                    });
                    btnElement.disabled = false;
                    btnElement.textContent = originalText;
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: data.message || 'No se pudo procesar la inscripción.',
                        icon: 'error',
                        confirmButtonColor: '#0c1381',
                        heightAuto: false
                    });
                    btnElement.disabled = false;
                    btnElement.textContent = originalText;
                }
            } catch (error) {
                console.error(error);
                Swal.fire({
                    title: 'Error de conexión',
                    text: 'No se pudo contactar con el servidor.',
                    icon: 'error',
                    confirmButtonColor: '#0c1381',
                    heightAuto: false
                });
                btnElement.disabled = false;
                btnElement.textContent = originalText;
            }
        }

        // Función para cancelar la inscripción
        async function desinscribirEstudiante(inscripcionId, btnElement) {
            const result = await Swal.fire({
                title: '¿Estás seguro?',
                text: '¿Realmente quieres cancelar tu inscripción a este curso?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Sí, cancelar',
                cancelButtonText: 'No, mantener',
                heightAuto: false
            });

            if (!result.isConfirmed) return;

            const originalText = btnElement.textContent;
            btnElement.disabled = true;
            btnElement.textContent = 'Cancelando...';

            try {
                const response = await fetch(`/inscripcion/${inscripcionId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (response.ok) {
                    await Swal.fire({
                        title: 'Cancelada',
                        text: 'Tu inscripción ha sido cancelada exitosamente.',
                        icon: 'success',
                        confirmButtonColor: '#0c1381',
                        heightAuto: false
                    });
                    location.reload();
                } else if (response.status === 429) {
                    Swal.fire({
                        title: 'Espera un momento',
                        text: data.message,
                        icon: 'info',
                        confirmButtonColor: '#0c1381',
                        heightAuto: false
                    });
                    btnElement.disabled = false;
                    btnElement.textContent = originalText;
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: data.message || 'No se pudo cancelar la inscripción.',
                        icon: 'error',
                        confirmButtonColor: '#0c1381',
                        heightAuto: false
                    });
                    btnElement.disabled = false;
                    btnElement.textContent = originalText;
                }
            } catch (error) {
                console.error(error);
                Swal.fire({
                    title: 'Error de conexión',
                    text: 'No se pudo contactar con el servidor.',
                    icon: 'error',
                    confirmButtonColor: '#0c1381',
                    heightAuto: false
                });
                btnElement.disabled = false;
                btnElement.textContent = originalText;
            }
        }

        document.querySelectorAll('.btn-inscribir').forEach(btn => {
            btn.addEventListener('click', function () {
                const cursoId = this.dataset.cursoId;
                const cursoCard = this.closest('.course-card');

                // Get name by removing the codigo span if it exists, or just get text
                const titleNode = cursoCard.querySelector('.card-title');
                const cursoNombre = titleNode.childNodes[0].textContent.trim();

                const spanCodigo = titleNode.querySelector('span');
                const cursoCodigo = spanCodigo ? spanCodigo.textContent.replace(/[()]/g, '') : '';

                const cursoCategoria = cursoCard.querySelector('.card-badge').textContent;

                // Animacion de feedback
                gsap.to(this, { scale: 0.95, duration: 0.1, yoyo: true, repeat: 1 });

                // Abrir el modal con los datos
                openModal(cursoId, cursoNombre, cursoCategoria, cursoCodigo);
            });
        });

        document.querySelectorAll('.btn-info').forEach(btn => {
            btn.addEventListener('click', function () {
                const cursoId = this.dataset.cursoId;
                gsap.to(this, { scale: 0.9, duration: 0.1, yoyo: true, repeat: 1 });
                // Tu logica de ver detalles aqui
                // window.location.href = `/cursos/${cursoId}`;
            });
        });
    </script>
</body>

</html>