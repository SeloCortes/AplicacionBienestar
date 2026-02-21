<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bienestar USC - Cursos</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-50">
    <div class="min-h-screen flex flex-col">
        <header class="border-b border-slate-200 bg-white">
            <div class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between gap-4">
                <div class="flex items-center gap-2">
                    <div class="h-9 w-9 rounded-lg bg-emerald-600 flex items-center justify-center text-white">
                        <span class="text-lg font-semibold">B</span>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-slate-900">Bienestar USC</p>
                        <p class="text-xs text-slate-500">Oferta de cursos</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 text-xs sm:text-sm">
                    <span class="px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 font-medium">
                        Estudiante
                    </span>
                </div>
            </div>
        </header>

        <main class="flex-1">
            <section class="max-w-6xl mx-auto px-4 py-8">
                <div class="max-w-2xl mb-8">
                    <h1 class="text-2xl sm:text-3xl font-semibold tracking-tight text-slate-900">
                        Elige tu curso de bienestar
                    </h1>
                    <p class="mt-2 text-sm sm:text-base text-slate-600">
                        Explora los cursos disponibles en Cátedra Santiaguina, Arte y cultura y Deporte formativo.
                    </p>
                </div>

                @php
                    $grupos = [
                        'Cátedra Santiaguina' => 'Catedra Santiaguina',
                        'Arte y cultura' => 'Arte y cultura',
                        'Deporte formativo' => 'Deporte formativo',
                    ];
                @endphp

                <div class="space-y-10">
                    @foreach ($grupos as $titulo => $clave)
                        @php
                            $cursosGrupo = $cursos->where('tipo_curso', $clave);
                        @endphp

                        @if ($cursosGrupo->isNotEmpty())
                            <section>
                                <header class="flex items-center justify-between mb-4">
                                    <div class="flex items-baseline gap-2">
                                        <h2 class="text-lg sm:text-xl font-semibold text-slate-900">
                                            {{ $titulo }}
                                        </h2>
                                        <span class="text-xs sm:text-sm text-slate-500">
                                            {{ $cursosGrupo->count() }} curso{{ $cursosGrupo->count() === 1 ? '' : 's' }}
                                        </span>
                                    </div>
                                </header>

                                <div class="grid gap-4 sm:gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
                                    @foreach ($cursosGrupo as $curso)
                                        <article class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden flex flex-col hover:shadow-md transition-shadow">
                                            @if ($curso->imagen)
                                                <div class="h-40 bg-slate-100 overflow-hidden">
                                                    <img
                                                        src="{{ asset($curso->imagen) }}"
                                                        alt="{{ $curso->nombre }}"
                                                        class="w-full h-full object-cover"
                                                    >
                                                </div>
                                            @endif

                                            <div class="p-4 sm:p-5 flex-1 flex flex-col">
                                                <div class="flex items-start justify-between gap-3 mb-2">
                                                    <h3 class="text-sm sm:text-base font-semibold text-slate-900">
                                                        {{ $curso->nombre }}
                                                    </h3>
                                                    <span class="inline-flex items-center rounded-full bg-emerald-50 px-2 py-0.5 text-[10px] sm:text-xs font-medium text-emerald-700">
                                                        {{ $curso->tipo_curso }}
                                                    </span>
                                                </div>

                                                @if ($curso->descripcion)
                                                    <p class="text-xs sm:text-sm text-slate-600 mb-4 line-clamp-3">
                                                        {{ $curso->descripcion }}
                                                    </p>
                                                @endif

                                                <div class="mt-auto pt-2 flex items-center justify-between">
                                                    <button
                                                        type="button"
                                                        class="inline-flex items-center justify-center rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs sm:text-sm font-medium text-slate-800 hover:bg-slate-50"
                                                        disabled
                                                    >
                                                        Ver horarios pronto
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
            </section>
        </main>
    </div>
</body>
</html>
