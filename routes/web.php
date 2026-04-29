<?php

use App\Http\Controllers\ActividadController;
use App\Http\Controllers\CentroController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\NoticiaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ControlController;
use App\Http\Controllers\Settings\ProfileController;
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

//Logeo
Route::get('/login', [ControlController::class, 'create'])->name('login');
Route::post('/login', [ControlController::class, 'store'])->name('login.store');


//Admin y jefe
Route::middleware(['auth', 'role:admin,jefe'])->group(function () {

    //Usuario
    Route::get('/usuarios/buscar',[UsuarioController::class,'buscar']);
    Route::resource('usuarios', UsuarioController::class);

    //Curso
    Route::post('/cursos/ocultar', [CursoController::class, 'ocultar']);
    Route::resource('cursos', CursoController::class)->except(['index','show']);


    Route::resource('horarios', HorarioController::class)->except(['index','show']);

    //Actividad
    Route::post('/actividades/ocultar', [ActividadController::class, 'ocultar']);
    Route::resource('actividades', ActividadController::class)->parameter('actividades', 'actividad')->except(['index','show']);
    
    Route::resource('noticias', NoticiaController::class)->except(['index','show']);
});


//Admin
Route::middleware(['auth', 'role:admin'])->group(function () {


    Route::post('/centros/ocultar', [CentroController::class, 'ocultar']);
    Route::resource('centros', CentroController::class)->except(['index','show']);

});
       
Route::middleware('auth')->group(function () {
    Route::post('/logout', [ControlController::class, 'logout'])->name('logout');;
});

//Centros
Route::get('/centros/buscar',[CentroController::class,'buscar'])->name('centros.buscar');
Route::resource('centros', CentroController::class)->only(['index', 'show']);


//Actividades
Route::middleware('auth')->group(function () {
    Route::get('/profile/history', [ProfileController::class, 'history'])->name('profile.history');
});
Route::get('/actividades/buscar',[ActividadController::class,'buscar'])->name('actividades.buscar');
Route::resource('actividades', ActividadController::class)->parameter('actividades', 'actividad')->only(['index', 'show']);


//Noticias
Route::resource('noticias', NoticiaController::class)->only(['index']);

//Cursos
Route::get('/cursos/buscar', [CursoController::class, 'buscar'])->name('centros.buscar');;
Route::resource('cursos', CursoController::class)->only(['index', 'show']);

//Horarios
Route::resource('horarios', HorarioController::class)->only(['index', 'show']);




require __DIR__.'/settings.php';