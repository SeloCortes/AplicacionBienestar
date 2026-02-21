<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('cursos.cursos');
});

use App\Http\Controllers\Auth\RegisterController;

// Ruta para registro de usuarios
Route::post('/register', [RegisterController::class, 'store']);
// Rutas para login de usuarios: GET muestra el formulario, POST procesa credenciales
use App\Http\Controllers\Auth\LoginController;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// //////////////////////////////////////////////////////////

use App\Http\Controllers\Admin\CursosAdminController;
use App\Http\Controllers\Admin\HorariosAdminController;
use App\Http\Controllers\CursosController;
use App\Http\Controllers\InscripcionController;

// grupo de rutas protegidas por autenticación
Route::middleware(['auth'])->group(function () {

    // Rutas para ver lista de cursos y horarios.

    Route::get('/cursos', [CursosController::class, 'index'])->name('cursos.index');
    Route::get('/cursos/{id}/horarios', [CursosController::class, 'horarios']);

    // Rutas para inscripciones de estudiantes y terceros.

    Route::post('/inscripcion', [InscripcionController::class, 'store'])->middleware('estudiante');
    Route::post('/inscripcion/tercero', [InscripcionController::class, 'store'])->middleware('tercero');
    Route::delete('/inscripcion/{id}', [InscripcionController::class, 'destroy'])->middleware(['estudiante', 'tercero']);

    // Rutas para administradores

    Route::middleware(['admin'])->group(function () {

        // cursos
        Route::post('/admin/cursos', [CursosAdminController::class, 'store']);
        Route::put('/admin/cursos/{id}', [CursosAdminController::class, 'update']);
        Route::delete('/admin/cursos/{id}', [CursosAdminController::class, 'destroy']);

        // Horarios
        Route::post('/admin/horarios', [HorariosAdminController::class, 'store']);
        Route::put('/admin/horarios/{id}', [HorariosAdminController::class, 'update']);
        Route::delete('/admin/horarios/{id}', [HorariosAdminController::class, 'destroy']);
    });

});
