<?php

use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});


use App\Http\Controllers\Auth\RegisterController;

Route::post('/register', [RegisterController::class, 'store']);

use App\Http\Controllers\Auth\LoginController;
Route::post('/login', [LoginController::class, 'login']);

use App\Http\Controllers\CursosController;
//Rutas para estudiantes y terceros
Route::get('/cursos', [CursosController::class, 'index']);
Route::get('/cursos/{id}/horarios', [CursosController::class,'horarios']);




use App\Http\Controllers\InscripcionController;
//Ruta para estudiantes
Route::post('/inscripcion', [InscripcionController::class,'store'])->middleware('estudiante');
//Ruta para terceros
Route::post('/inscripcion/tercero', [InscripcionController::class,'store'])->middleware('tercero');

Route::delete('/inscripcion/{id}', [InscripcionController::class,'destroy'])->middleware(['estudiante', 'tercero']);


use App\Http\Controllers\Admin\CursosAdminController;
use App\Http\Controllers\Admin\HorariosAdminController;

//Rutas para administradores
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

