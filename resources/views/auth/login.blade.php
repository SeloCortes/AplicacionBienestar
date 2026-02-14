<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#3d8b7a">
    <title>Bienestar USC - Iniciar Sesion</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@500;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="login-page">
        {{-- Left: Form Panel --}}
        <div class="form-panel">
            <div class="form-wrapper">
                {{-- Logo & Header --}}
                <header class="login-header">
                    <div class="logo-row">
                        <div class="logo-icon">
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                            </svg>
                        </div>
                        <span class="logo-text">Bienestar USC</span>
                    </div>
                    <h1>Bienvenido de nuevo</h1>
                    <p>Inicia sesion para inscribirte a cursos y actividades de bienestar.</p>
                </header>

                {{-- Login Form --}}
                <form id="login-form" class="login-form">
                    @csrf

                    {{-- Identificacion --}}
                    <div class="field">
                        <label for="identificacion">Identificacion</label>
                        <div class="input-wrapper">
                            {{-- User icon --}}
                            <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                            <input
                                id="identificacion"
                                name="identificacion"
                                type="text"
                                autocomplete="username"
                                required
                                placeholder="Ingresa tu identificacion"
                            >
                        </div>
                        <div class="error-text" data-error-identificacion></div>
                    </div>

                    {{-- Contrasena --}}
                    <div class="field">
                        <label for="password">Contrasena</label>
                        <div class="input-wrapper">
                            {{-- Lock icon --}}
                            <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>
                            <input
                                id="password"
                                name="password"
                                type="password"
                                autocomplete="current-password"
                                required
                                placeholder="Ingresa tu contrasena"
                                class="password-input"
                            >
                            {{-- Toggle password visibility --}}
                            <button type="button" class="toggle-password" id="togglePassword" aria-label="Mostrar contrasena">
                                {{-- Eye icon (shown when password is hidden) --}}
                                <svg id="eyeIcon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                                {{-- EyeOff icon (shown when password is visible) --}}
                                <svg id="eyeOffIcon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none;">
                                    <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/>
                                    <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/>
                                    <path d="M14.12 14.12a3 3 0 1 1-4.24-4.24"/>
                                    <line x1="1" y1="1" x2="23" y2="23"/>
                                </svg>
                            </button>
                        </div>
                        <div class="error-text" data-error-password></div>
                    </div>

                    {{-- Error message box --}}
                    <div class="message-box" id="mensaje"></div>

                    {{-- Submit --}}
                    <button type="submit" class="btn-submit" id="btnEnviar">
                        <span class="spinner"></span>
                        <span class="btn-text">Entrar</span>
                        <span class="btn-loading-text">Iniciando sesion...</span>
                    </button>
                </form>

                <p class="helper-text">
                    No tienes cuenta?
                    <a href="{{ url('/register') }}">Registrate</a>
                </p>
            </div>
        </div>

        {{-- Right: Brand Panel --}}
        <div class="brand-panel-wrapper">
            <div class="brand-panel">
                {{-- Replace src with your actual campus image path --}}
                <img
                    class="brand-panel-img"
                    src="{{ asset('images/login-bg.jpg') }}"
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
        // ── GSAP Animations ──
        window.addEventListener('load', () => {
            const tl = gsap.timeline();
            
            // Animación del panel de marca (derecha)
            tl.from(".brand-panel-wrapper", {
                xPercent: 100,
                duration: 1.2,
                ease: "power4.out"
            });

            // Animación del logo y cabecera
            tl.from(".login-header", {
                opacity: 0,
                y: 20,
                duration: 0.8,
                ease: "power2.out"
            }, "-=0.6");

            // Animación de los campos del formulario uno por uno
            tl.from(".field", {
                opacity: 0,
                y: 15,
                stagger: 0.15,
                duration: 0.6,
                ease: "power2.out"
            }, "-=0.4");

            // Animación del botón y link de registro
            tl.from([".btn-submit", ".helper-text"], {
                opacity: 0,
                y: 10,
                duration: 0.5,
                ease: "power2.out"
            }, "-=0.2");
        });

        // ── DOM references ──
        const form = document.getElementById('login-form');
        const btn = document.getElementById('btnEnviar');
        const msg = document.getElementById('mensaje');
        const errIdent = document.querySelector('[data-error-identificacion]');
        const errPass = document.querySelector('[data-error-password]');
        const passwordInput = document.getElementById('password');
        const toggleBtn = document.getElementById('togglePassword');
        const eyeIcon = document.getElementById('eyeIcon');
        const eyeOffIcon = document.getElementById('eyeOffIcon');

        // ── Toggle password visibility ──
        toggleBtn.addEventListener('click', () => {
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            eyeIcon.style.display = isPassword ? 'none' : 'block';
            eyeOffIcon.style.display = isPassword ? 'block' : 'none';
            toggleBtn.setAttribute('aria-label', isPassword ? 'Ocultar contrasena' : 'Mostrar contrasena');
        });

        // ── Form submission ──
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            msg.textContent = '';
            msg.classList.remove('visible');
            errIdent.textContent = '';
            errPass.textContent = '';
            btn.disabled = true;
            btn.classList.add('loading');

            try {
                const formData = new FormData(form);
                const res = await fetch('{{ url("/login") }}', {
                    method: 'POST',
                    headers: { 'Accept': 'application/json' },
                    body: formData
                });
                const data = await res.json().catch(() => ({}));

                if (res.ok) {
                    const target = data && data.redirect_url ? data.redirect_url : '{{ url("/cursos") }}';
                    window.location.href = target;
                    return;
                }

                msg.textContent = (data && data.message) ? data.message : 'Error al iniciar sesion';
                msg.classList.add('visible');

                const errors = (data && data.errors) ? data.errors : {};
                if (errors.identificacion && errors.identificacion[0]) errIdent.textContent = errors.identificacion[0];
                if (errors.password && errors.password[0]) errPass.textContent = errors.password[0];
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