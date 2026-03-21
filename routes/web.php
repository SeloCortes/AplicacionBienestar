<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

use App\Http\Controllers\Auth\RegisterController;

// Ruta para registro de usuarios
Route::post('/register', [RegisterController::class , 'store']);


// Rutas para login de usuarios: GET muestra el formulario, POST procesa credenciales
use App\Http\Controllers\Auth\LoginController;

Route::get('/login', [LoginController::class , 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class , 'login']);
Route::post('/logout', [LoginController::class , 'logout'])->name('logout')->middleware('auth');

// //////////////////////////////////////////////////////////

use App\Http\Controllers\Admin\CursosAdminController;
use App\Http\Controllers\Admin\HorariosAdminController;
use App\Http\Controllers\CursosController;
use App\Http\Controllers\InscripcionController;
use App\Http\Controllers\Admin\InfomersAdminController;

// grupo de rutas protegidas por autenticación
Route::middleware(['auth'])->group(function () {

    // Rutas para ver lista de cursos y horarios.
    Route::get('/cursos', [CursosController::class , 'index'])->name('cursos.index');
    Route::get('/cursos/{id}/horarios', [CursosController::class , 'horarios']);


    // Rutas para inscripciones de estudiantes y terceros.
    Route::post('/inscripcion', [InscripcionController::class , 'store'])->middleware('estudiante');
    Route::post('/inscripcion/tercero', [InscripcionController::class , 'store'])->middleware('tercero');
    Route::delete('/inscripcion/{id}', [InscripcionController::class , 'destroy']);


    // Rutas para administradores
    Route::middleware(['admin'])->group(function () {

            // cursos
            Route::get('/admin/cursos', [CursosAdminController::class , 'index'])->name('admin.cursos.index');
            Route::post('/admin/cursos', [CursosAdminController::class , 'store']);
            Route::put('/admin/cursos/{id}', [CursosAdminController::class , 'update']);
            Route::delete('/admin/cursos/{id}', [CursosAdminController::class , 'destroy']);

            // Horarios
            Route::post('/admin/horarios', [HorariosAdminController::class , 'store']);
            Route::put('/admin/horarios/{id}', [HorariosAdminController::class , 'update']);
            Route::delete('/admin/horarios/{id}', [HorariosAdminController::class , 'destroy']);


            // Informes 
            Route::get('/admin/informe', [InfomersAdminController::class , 'index'])->name('admin.informe.index');
            Route::get('/admin/informe/generar', [InformeAdminController::class , 'generar']);
            
        }
        );
    });
