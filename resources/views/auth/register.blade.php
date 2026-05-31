<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="theme-color" content="#3d8b7a">
    <title>Bienestar USC - Registro</title>
    
    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    
    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@500;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        .form-wrapper {
            max-width: 520px !important;
            padding: 1rem 0;
        }
        .form-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 0.75rem 1rem;
        }
        .full-width {
            grid-column: span 1;
        }
        @media (min-width: 576px) {
            .form-grid {
                grid-template-columns: 1fr 1fr;
            }
            .full-width {
                grid-column: span 2;
            }
        }
        .input-wrapper select {
            display: flex;
            height: 2.75rem;
            width: 100%;
            border-radius: var(--radius);
            border: 1px solid var(--border);
            background: var(--card);
            padding: 0 0.75rem 0 2.5rem;
            font-size: 0.875rem;
            font-family: inherit;
            color: var(--foreground);
            transition: border-color 0.15s, box-shadow 0.15s;
            outline: none;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml;utf8,<svg fill='%236b7f7a' height='24' viewBox='0 0 24 24' width='24' xmlns='http://www.w3.org/2000/svg'><path d='M7 10l5 5 5-5z'/><path d='M0 0h24v24H0z' fill='none'/></svg>");
            background-repeat: no-repeat;
            background-position-x: calc(100% - 0.75rem);
            background-position-y: 50%;
        }
        .input-wrapper select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px var(--ring);
        }
        .conditional-section {
            display: none;
            border-top: 1px dashed var(--border);
            padding-top: 1rem;
            margin-top: 0.5rem;
        }
        .conditional-section.active {
            display: block;
        }
        .error-text {
            min-height: auto;
            margin-bottom: 0.25rem;
        }
        .helper-text {
            margin-top: 1rem;
        }
    </style>
</head>
<body>
    <div class="login-page">
        {{-- Left: Form Panel --}}
        <div class="form-panel" style="overflow-y: auto;">
            <div class="form-wrapper">
                {{-- Logo & Header --}}
                <header class="login-header">
                    <div class="logo-row">
                        <div class="logo-icon">
                            <img src="{{ asset('images/Logo_Universidad-Santiago-de-Cali.png') }}" alt="Logo USC" width="56" height="56">
                        </div>
                        <span class="logo-text">Bienestar USC</span>
                    </div>
                    <h1>Crea tu cuenta</h1>
                    <p>Regístrate para acceder a los servicios y actividades de bienestar universitario.</p>
                </header>

                {{-- Registration Form --}}
                <form id="register-form" class="login-form">
                    @csrf

                    <div class="form-grid">
                        {{-- Nombre y Apellidos --}}
                        <div class="field full-width">
                            <label for="nombre_apellido">Nombre y Apellidos Completos</label>
                            <div class="input-wrapper">
                                <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                    <circle cx="12" cy="7" r="4"/>
                                </svg>
                                <input id="nombre_apellido" name="nombre_apellido" type="text" required placeholder="Ingresa tus nombres y apellidos">
                            </div>
                            <div class="error-text" data-error-nombre_apellido></div>
                        </div>

                        {{-- Identificacion --}}
                        <div class="field">
                            <label for="identificacion">Identificación (Cédula/T.I.)</label>
                            <div class="input-wrapper">
                                <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="4" width="18" height="16" rx="2" ry="2"/>
                                    <line x1="7" y1="8" x2="17" y2="8"/>
                                    <line x1="7" y1="12" x2="17" y2="12"/>
                                    <line x1="7" y1="16" x2="13" y2="16"/>
                                </svg>
                                <input id="identificacion" name="identificacion" type="text" required placeholder="Número de documento">
                            </div>
                            <div class="error-text" data-error-identificacion></div>
                        </div>

                        {{-- Correo --}}
                        <div class="field">
                            <label for="correo">Correo Electrónico</label>
                            <div class="input-wrapper">
                                <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                    <polyline points="22,6 12,13 2,6"/>
                                </svg>
                                <input id="correo" name="correo" type="email" required placeholder="ejemplo@correo.com">
                            </div>
                            <div class="error-text" data-error-correo></div>
                        </div>

                        {{-- Contraseña --}}
                        <div class="field">
                            <label for="password">Contraseña</label>
                            <div class="input-wrapper">
                                <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                                </svg>
                                <input id="password" name="password" type="password" required placeholder="Mínimo 8 caracteres" class="password-input">
                            </div>
                            <div class="error-text" data-error-password></div>
                        </div>

                        {{-- Confirmar Contraseña --}}
                        <div class="field">
                            <label for="password_confirmation">Confirmar Contraseña</label>
                            <div class="input-wrapper">
                                <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                                </svg>
                                <input id="password_confirmation" name="password_confirmation" type="password" required placeholder="Repite la contraseña" class="password-input">
                            </div>
                            <div class="error-text" data-error-password_confirmation></div>
                        </div>

                        {{-- Telefono --}}
                        <div class="field">
                            <label for="telefono">Teléfono</label>
                            <div class="input-wrapper">
                                <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                                </svg>
                                <input id="telefono" name="telefono" type="text" placeholder="Número de celular">
                            </div>
                            <div class="error-text" data-error-telefono></div>
                        </div>

                        {{-- Genero --}}
                        <div class="field">
                            <label for="genero">Género</label>
                            <div class="input-wrapper">
                                <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"/>
                                    <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
                                </svg>
                                <select id="genero" name="genero">
                                    <option value="" selected disabled>Selecciona tu género</option>
                                    <option value="Femenino">Femenino</option>
                                    <option value="Masculino">Masculino</option>
                                    <option value="Otro">Otro</option>
                                    <option value="Prefiero no decirlo">Prefiero no decirlo</option>
                                </select>
                            </div>
                            <div class="error-text" data-error-genero></div>
                        </div>

                        {{-- Etnia --}}
                        <div class="field">
                            <label for="etnia">Etnia (Opcional)</label>
                            <div class="input-wrapper">
                                <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                                </svg>
                                <input id="etnia" name="etnia" type="text" placeholder="Ej: Mestizo, Afrocolombiano">
                            </div>
                            <div class="error-text" data-error-etnia></div>
                        </div>

                        {{-- Discapacidad --}}
                        <div class="field">
                            <label for="discapacidad">Discapacidad (Opcional)</label>
                            <div class="input-wrapper">
                                <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"/>
                                    <line x1="12" y1="8" x2="12" y2="12"/>
                                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                                </svg>
                                <input id="discapacidad" name="discapacidad" type="text" placeholder="Ej: Ninguna, Visual, Motora">
                            </div>
                            <div class="error-text" data-error-discapacidad></div>
                        </div>

                        {{-- Rol --}}
                        <div class="field full-width">
                            <label for="rol">Tipo de Usuario (Rol)</label>
                            <div class="input-wrapper">
                                <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                    <circle cx="9" cy="7" r="4"/>
                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                                </svg>
                                <select id="rol" name="rol" required>
                                    <option value="" selected disabled>Selecciona tu rol</option>
                                    <option value="Estudiante">Estudiante</option>
                                    <option value="Tercero">Tercero</option>
                                </select>
                            </div>
                            <div class="error-text" data-error-rol></div>
                        </div>
                    </div>

                    {{-- Campos condicionales de Estudiante --}}
                    <div id="student-fields" class="conditional-section full-width">
                        <div class="form-grid">
                            <div class="field">
                                <label for="facultad">Facultad</label>
                                <div class="input-wrapper">
                                    <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                                        <path d="M6 12v5c0 2 2 3 6 3s6-1 6-3v-5"/>
                                    </svg>
                                    <select id="facultad" name="facultad">
                                        <option value="" selected disabled>Selecciona tu facultad</option>
                                        @foreach ($facultades as $fac)
                                            <option value="{{ $fac }}">{{ $fac }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="error-text" data-error-facultad></div>
                            </div>

                            <div class="field">
                                <label for="nombre_carrera">Programa Académico</label>
                                <div class="input-wrapper">
                                    <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                                        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                                    </svg>
                                    <select id="nombre_carrera" name="nombre_carrera">
                                        <option value="" selected disabled>Selecciona tu programa</option>
                                    </select>
                                </div>
                                <div class="error-text" data-error-nombre_carrera></div>
                            </div>

                            <div class="field full-width">
                                <label for="semestre">Semestre</label>
                                <div class="input-wrapper">
                                    <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M12 20h9"/>
                                        <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/>
                                    </svg>
                                    <input id="semestre" name="semestre" type="number" min="1" max="20" placeholder="Ej: 5">
                                </div>
                                <div class="error-text" data-error-semestre></div>
                            </div>
                        </div>
                    </div>

                    {{-- Campos condicionales de Tercero --}}
                    <div id="tercero-fields" class="conditional-section full-width">
                        <div class="form-grid">
                            <div class="field full-width">
                                <label for="estamento">Estamento / Tipo de Tercero</label>
                                <div class="input-wrapper">
                                    <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                                        <polyline points="3.27 6.96 12 12.01 20.73 6.96"/>
                                        <line x1="12" y1="22.08" x2="12" y2="12"/>
                                    </svg>
                                    <select id="estamento" name="estamento">
                                        <option value="" selected disabled>Selecciona tu estamento</option>
                                        <option value="Egresado">Egresado</option>
                                        <option value="Maestro">Maestro</option>
                                        <option value="Externo">Externo</option>
                                        <option value="Personal universitario(no tiene permisos de administrador)">Personal universitario (no tiene permisos de administrador)</option>
                                    </select>
                                </div>
                                <div class="error-text" data-error-estamento></div>
                            </div>
                        </div>
                    </div>

                    {{-- Error message box --}}
                    <div class="message-box full-width" id="mensaje"></div>

                    {{-- Submit --}}
                    <button type="submit" class="btn-submit full-width" id="btnEnviar">
                        <span class="spinner"></span>
                        <span class="btn-text">Registrarse</span>
                        <span class="btn-loading-text">Creando cuenta...</span>
                    </button>
                </form>

                <p class="helper-text">
                    ¿Ya tienes cuenta?
                    <a href="{{ url('/login') }}">Inicia sesión</a>
                </p>
            </div>
        </div>

        {{-- Right: Brand Panel --}}
        <div class="brand-panel-wrapper">
            <div class="brand-panel">
                <img
                    class="brand-panel-img"
                    src="{{ asset('images/login-bg.webp') }}"
                    alt="Campus universitario con estudiantes en un entorno de bienestar"
                >
                <div class="brand-panel-overlay"></div>
                <div class="brand-panel-content">
                    <blockquote class="brand-panel-quote">
                        &ldquo;Cuidar de tu bienestar es invertir en tu futuro academico y personal.&rdquo;
                    </blockquote>
                    <div class="brand-panel-divider">
                        <div class="line"></div>
                        <span>Bienestar USC</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script>
        // ── GSAP Entry Animations ──
        window.addEventListener('load', () => {
            const tl = gsap.timeline();
            
            tl.from(".brand-panel-wrapper", {
                xPercent: 100,
                duration: 1.2,
                ease: "power4.out"
            });

            tl.from(".login-header", {
                opacity: 0,
                y: 20,
                duration: 0.8,
                ease: "power2.out"
            }, "-=0.6");

            tl.from(".field", {
                opacity: 0,
                y: 15,
                stagger: 0.08,
                duration: 0.6,
                ease: "power2.out"
            }, "-=0.4");

            tl.from([".btn-submit", ".helper-text"], {
                opacity: 0,
                y: 10,
                duration: 0.5,
                ease: "power2.out"
            }, "-=0.2");
        });

        // ── Conditional Fields Switcher ──
        const rolSelect = document.getElementById('rol');
        const studentFields = document.getElementById('student-fields');
        const terceroFields = document.getElementById('tercero-fields');

        // Inputs for disabling / enabling based on role
        const studentInputs = studentFields.querySelectorAll('input, select');
        const terceroInputs = terceroFields.querySelectorAll('input, select');

        function toggleInputs(inputs, enable) {
            inputs.forEach(input => {
                input.disabled = !enable;
                if (!enable) {
                    input.value = ''; // Reset values when disabled
                }
            });
        }

        // Disable all conditional fields initially
        toggleInputs(studentInputs, false);
        toggleInputs(terceroInputs, false);

        rolSelect.addEventListener('change', (e) => {
            const val = e.target.value;
            
            if (val === 'Estudiante') {
                studentFields.classList.add('active');
                terceroFields.classList.remove('active');
                toggleInputs(studentInputs, true);
                toggleInputs(terceroInputs, false);
                
                // GSAP smooth fade in
                gsap.fromTo(studentFields, { opacity: 0, y: -10 }, { opacity: 1, y: 0, duration: 0.4, ease: "power2.out" });
            } else if (val === 'Tercero') {
                terceroFields.classList.add('active');
                studentFields.classList.remove('active');
                toggleInputs(terceroInputs, true);
                toggleInputs(studentInputs, false);
                
                // GSAP smooth fade in
                gsap.fromTo(terceroFields, { opacity: 0, y: -10 }, { opacity: 1, y: 0, duration: 0.4, ease: "power2.out" });
            } else {
                studentFields.classList.remove('active');
                terceroFields.classList.remove('active');
                toggleInputs(studentInputs, false);
                toggleInputs(terceroInputs, false);
            }
        });

        // ── Dynamic Faculty/Program Dropdowns ──
        const facultadesProgramas = @json($facultadesProgramas);
        const facultadSelect = document.getElementById('facultad');
        const programaSelect = document.getElementById('nombre_carrera');

        facultadSelect.addEventListener('change', function() {
            const selectedFacultad = this.value;
            const programas = facultadesProgramas[selectedFacultad] || [];
            
            programaSelect.innerHTML = '<option value="" selected disabled>Selecciona tu programa</option>';
            
            programas.forEach(prog => {
                const option = document.createElement('option');
                option.value = prog;
                option.textContent = prog;
                programaSelect.appendChild(option);
            });
        });

        // ── Form Submission via AJAX ──
        const form = document.getElementById('register-form');
        const btn = document.getElementById('btnEnviar');
        const msg = document.getElementById('mensaje');

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            // Reset errors
            msg.textContent = '';
            msg.classList.remove('visible');
            document.querySelectorAll('.error-text').forEach(el => el.textContent = '');
            
            btn.disabled = true;
            btn.classList.add('loading');

            try {
                const formData = new FormData(form);
                const res = await fetch('{{ url("/register") }}', {
                    method: 'POST',
                    headers: { 'Accept': 'application/json' },
                    body: formData
                });
                
                const data = await res.json().catch(() => ({}));

                if (res.ok) {
                    // SweetAlert de registro exitoso, espera al click del botón para redirigir a Login
                    Swal.fire({
                        title: '¡Registro Exitoso!',
                        text: 'Tu cuenta ha sido creada correctamente. Presiona Aceptar para continuar al inicio de sesión.',
                        icon: 'success',
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor: '#0c1381',
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '{{ url("/login") }}';
                        }
                    });
                    return;
                }

                // Mostrar error general
                msg.textContent = (data && data.message) ? data.message : 'Ocurrió un error al procesar el registro';
                msg.classList.add('visible');

                // Pintar errores específicos
                const errors = (data && data.errors) ? data.errors : {};
                for (const [field, messages] of Object.entries(errors)) {
                    const errEl = document.querySelector(`[data-error-${field}]`);
                    if (errEl) {
                        errEl.textContent = messages[0];
                    }
                }
            } catch (_) {
                msg.textContent = 'No se pudo contactar al servidor';
                msg.classList.add('visible');
            } finally {
                btn.disabled = false;
                btn.classList.remove('loading');
            }
        });
    </script>
</body>
</html>
