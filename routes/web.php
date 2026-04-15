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

Route::inertia('/', 'welcome', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');

// Route::middleware(['auth', 'verified'])->group(function () {
// });
Route::inertia('dashboard', 'dashboard')->name('dashboard');

Route::get('/inicio', [InicioController::class, 'index'])->name('inicio.index');

Route::resource('centros', CentroController::class);
Route::resource('actividades', ActividadController::class)->parameter('actividades', 'actividad');
Route::resource('noticias', NoticiaController::class);
Route::resource('cursos', CursoController::class);
Route::resource('horarios', HorarioController::class);

require __DIR__.'/settings.php';
