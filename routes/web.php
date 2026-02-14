<?php

use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('auth.login');
});


use App\Http\Controllers\Auth\RegisterController;
//Ruta para registro de usuarios
Route::post('/register', [RegisterController::class, 'store']);
//Ruta para login de usuarios
use App\Http\Controllers\Auth\LoginController;
Route::post('/login', [LoginController::class, 'login']);
Route::get('/login', function () {
    return view('auth.login');
})->name('login');


//Rutas para ver lista de cursos y horarios.
use App\Http\Controllers\CursosController;
Route::get('/cursos', [CursosController::class, 'index']);
Route::get('/cursos/{id}/horarios', [CursosController::class,'horarios']);


//Rutas para inscripciones de estudiantes y terceros.
use App\Http\Controllers\InscripcionController;
Route::post('/inscripcion', [InscripcionController::class,'store'])->middleware('estudiante');
Route::post('/inscripcion/tercero', [InscripcionController::class,'store'])->middleware('tercero');
Route::delete('/inscripcion/{id}', [InscripcionController::class,'destroy'])->middleware(['estudiante', 'tercero']);


//Rutas para administradores
use App\Http\Controllers\Admin\CursosAdminController;
use App\Http\Controllers\Admin\HorariosAdminController;
Route::middleware(['admin'])->group(function () {

    //cursos 
    Route::post('/admin/cursos',[CursosAdminController::class,'store']);
    Route::put('/admin/cursos/{id}', [CursosAdminController::class,'update']);
    Route::delete('/admin/cursos/{id}', [CursosAdminController::class,'destroy']);

    //Horarios
    Route::post('/admin/horarios', [HorariosAdminController::class,'store']);
    Route::put('/admin/horarios/{id}', [HorariosAdminController::class,'update']);
    Route::delete('/admin/horarios/{id}', [HorariosAdminController::class,'destroy']);
});
