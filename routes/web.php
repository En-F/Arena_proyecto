<?php

use App\Http\Controllers\ActividadController;
use App\Http\Controllers\CentroController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\NoticiaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ControlController;
use App\Models\Horario;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::inertia('/', 'Inicio/index', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');

// Route::middleware(['auth', 'verified'])->group(function () {
// });
Route::inertia('dashboard', 'dashboard')->name('dashboard');

Route::get('/inicio', [InicioController::class, 'index'])->name('inicio.index');

Route::get('/login', [ControlController::class, 'create'])->name('login');
Route::post('/login', [ControlController::class, 'store'])->name('login.store');


Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('centros', CentroController::class)->except(['index','show']);
    Route::resource('cursos', CursoController::class)->except(['index','show']);
    Route::resource('horarios', HorarioController::class)->except(['index','show']);
    Route::resource('actividades', ActividadController::class)->parameter('actividades', 'actividad')->except(['index','show']);
    Route::resource('noticias', NoticiaController::class)->except(['index','show']);
    Route::resource('usuarios', UsuarioController::class);
});
    
Route::middleware('auth')->group(function () {
    Route::get('/logout', [ControlController::class,'logout' ])->name('logout');
    Route::post('/logout', [ControlController::class, 'logout']);
});


Route::get('/centros/buscar',[CentroController::class,'buscar'])->name('centros.buscar');
Route::resource('centros', CentroController::class)->only(['index', 'show']);



Route::get('/actividades/buscar',[ActividadController::class,'buscar'])->name('actividades.buscar');
Route::resource('actividades', ActividadController::class)->parameter('actividades', 'actividad')->only(['index', 'show']);


Route::resource('noticias', NoticiaController::class)->only(['index']);
Route::resource('cursos', CursoController::class)->only(['index', 'show']);
Route::resource('horarios', HorarioController::class)->only(['index', 'show']);




require __DIR__.'/settings.php';