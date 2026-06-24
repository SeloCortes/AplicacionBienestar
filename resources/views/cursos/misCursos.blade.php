<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#3d8b7a">
    <title>Bienestar USC - Mis Cursos</title>
    <link rel="stylesheet" href="{{ asset('css/student.css') }}">
    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@500;600;700&family=Inter:wght@400;500;600&display=swap"
        rel="stylesheet">

    {{-- FullCalendar --}}
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>

    <style>
        .main-content {
            padding: 0.1rem 0.1rem;
        }

        .calendar-container {
            background: white;
            padding: 1.5rem;
            border-radius: var(--radius-xl);
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            min-height: 600px;
        }

        .fc-event {
            cursor: pointer;
            padding: 2px 4px;
            border: none;
            border-radius: 4px;
        }

        .fc-v-event .fc-event-main {
            color: white;
        }

        /* Colores basados en el diseño base */
        .event-deporte {
            background-color: var(--emerald-bg) !important;
            border-left: 4px solid var(--emerald-text) !important;
            color: var(--emerald-text) !important;
        }

        .event-arte {
            background-color: var(--amber-bg) !important;
            border-left: 4px solid var(--amber-text) !important;
            color: var(--amber-text) !important;
        }

        .event-catedra {
            background-color: var(--sky-bg) !important;
            border-left: 4px solid var(--sky-text) !important;
            color: var(--sky-text) !important;
        }

        .fc-timegrid-slot {
            height: 1em !important;
        }

        /* Reducir el tamaño general del calendario */
        .fc {
            font-size: 0.65rem;
            /* Ajusta a 0.7rem o 0.65rem si necesitas más espacio */
        }

        /* Reducir la altura de cada bloque de tiempo */
        .fc .fc-timegrid-slot {
            height: 1.5rem !important;
            /* Valor por defecto suele ser mayor */
        }

        /* Reducir el tamaño del texto de las horas */
        .fc .fc-timegrid-slot-label {
            font-size: 0.7rem;
        }

        /* Reducir el tamaño de los encabezados de los días */
        .fc .fc-col-header-cell {
            font-size: 1rem;
            padding: 2px 0;
        }

        /* Reducir el tamaño de los eventos */
        .fc .fc-timegrid-event {
            font-size: 0.85rem;
            padding: 1px 2px;
        }

        /* Responsive Mobile Styles */
        @media (max-width: 768px) {
            .calendar-container {
                padding: 0.5rem;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }
            
            #calendar {
                min-width: 600px; /* Fuerza el scroll horizontal en lugar de aplastar las columnas */
            }

            .fc .fc-col-header-cell {
                font-size: 0.8rem;
            }

            .fc .fc-timegrid-slot-label {
                font-size: 0.6rem;
            }

            .main-content {
                padding: 0.5rem;
            }
        }
    </style>
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
                        <span class="logo-title">SIBIU</span>
                        <span class="logo-subtitle">Bienestar USC</span>
                    </div>
                </a>

                <nav class="student-nav" style="display: flex; gap: 1.5rem; margin-left: 2rem;">
                    <a href="{{ route('cursos.index') }}" class="nav-link"
                        style="text-decoration: none; color: var(--muted-foreground); font-weight: 500; transition: all 0.2s;">Explorar
                        Cursos</a>
                    <a href="{{ route('cursos.mis-cursos') }}" class="nav-link active"
                        style="text-decoration: none; color: var(--primary); font-weight: 700; border-bottom: 2px solid var(--primary); padding-bottom: 4px;">Mis
                        Cursos</a>
                </nav>

                <div class="header-actions">
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
            <div class="calendar-container">
                @if(isset($inscripcionesAbiertas) && !$inscripcionesAbiertas)
                <div style="background: #fee2e2; color: #b91c1c; padding: 1rem; border-radius: var(--radius-md); text-align: center; margin-bottom: 2rem; font-weight: 600; border: 1px solid #fca5a5;">
                    Las inscripciones y cancelaciones se encuentran cerradas en este momento.
                </div>
                @endif
                <div id='calendar'></div>
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
    </div>

    <script>
        const userInscriptions = @json($userInscriptions);

        // Mapeo de dias
        const daysMap = {
            'Domingo': 0,
            'Lunes': 1,
            'Martes': 2,
            'Miércoles': 3,
            'Miercoles': 3,
            'Jueves': 4,
            'Viernes': 5,
            'Sábado': 6,
            'Sabado': 6
        };

        const events = userInscriptions.map(ins => {
            const h = ins.horario;
            const c = h.curso;

            let className = '';
            let color = '';
            if (c.tipo_curso === 'Deporte formativo') { className = 'event-deporte'; color = '#059669'; } // emerald-600
            else if (c.tipo_curso === 'Arte y cultura') { className = 'event-arte'; color = '#d97706'; } // amber-600
            else { className = 'event-catedra'; color = '#0284c7'; } // sky-600

            let title = c.nombre;
            if (c.codigo) title += ` (${c.codigo})`;

            return {
                title: title,
                daysOfWeek: [daysMap[h.dia]],
                startTime: h.hora_inicio.substring(0, 5),
                endTime: h.hora_fin.substring(0, 5),
                extendedProps: {
                    profesor: h.profesor || 'Por asignar',
                    salon: h.salon || 'Por asignar',
                    categoria: c.tipo_curso
                },
                backgroundColor: color,
                borderColor: color,
                textColor: 'white'
            };
        });

        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'timeGridWeek',
                locale: 'es',
                headerToolbar: false, // Ocultar header ya que es un horario recurrente
                dayHeaderFormat: { weekday: 'long' }, // Solo mostrar Lunes, Martes...
                slotMinTime: '06:00:00', // Empezar a las 6 AM
                slotMaxTime: '22:00:00', // Terminar a las 10 PM
                height: "auto",
                allDaySlot: false, // Ocultar fila de todo el día
                hiddenDays: [0], // Ocultar Domingo por defecto, cambiar si hay clases domingo
                events: events,
                eventContent: function (arg) {
                    return {
                        html: `
                            <div style="font-size:0.85em; font-weight:bold; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                                ${arg.event.title}
                            </div>
                            <div style="font-size:0.75em; opacity:0.9;">
                                ${arg.timeText}
                            </div>
                            <div style="font-size:0.75em; margin-top:2px;">
                                📍 ${arg.event.extendedProps.salon}
                            </div>
                        `
                    };
                }
            });
            calendar.render();
        });
    </script>
</body>

</html>