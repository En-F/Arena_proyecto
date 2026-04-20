<?php

use App\Http\Controllers\ActividadController;
use App\Http\Controllers\CentroController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\NoticiaController;
use App\Models\Horario;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

<<<<<<< HEAD
Route::inertia('/', 'welcome', [
=======
Route::inertia('/', 'Inicio/index', [
>>>>>>> fb55ae0 (Intregración de las cookies)
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');

// Route::middleware(['auth', 'verified'])->group(function () {
// });
Route::inertia('dashboard', 'dashboard')->name('dashboard');

Route::get('/inicio', [InicioController::class, 'index'])->name('inicio.index');


<<<<<<< HEAD
=======

>>>>>>> fb55ae0 (Intregración de las cookies)
Route::get('/centros/buscar',[CentroController::class,'buscar'])->name('centros.buscar');
Route::resource('centros', CentroController::class);




Route::get('/actividades/buscar',[ActividadController::class,'buscar'])->name('actividades.buscar');
Route::resource('actividades', ActividadController::class)->parameter('actividades', 'actividad');


Route::resource('noticias', NoticiaController::class);
Route::resource('cursos', CursoController::class);
Route::resource('horarios', HorarioController::class);

require __DIR__.'/settings.php';
