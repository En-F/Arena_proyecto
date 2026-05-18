<?php

use App\Http\Controllers\ActividadController;
use App\Http\Controllers\BeneficioController;
use App\Http\Controllers\CentroController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\NoticiaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ControlController;
use App\Http\Controllers\Settings\ProfileController;
use App\Http\Controllers\ValoracionController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\InstalacionController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\SesionController;
use App\Models\Horario;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::inertia('/', 'Inicio/index', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');

// Route::middleware(['auth', 'verified'])->group(function () {
// });

Route::get('/inicio', [InicioController::class, 'index'])->name('inicio.index');

//Centros
Route::get('/centros/buscar',[CentroController::class,'buscar'])->name('centros.buscar');
Route::resource('centros', CentroController::class)->only(['index', 'show']);


//Actividades
Route::get('/actividades/buscar',[ActividadController::class,'buscar'])->name('actividades.buscar');
Route::resource('actividades', ActividadController::class)->parameter('actividades', 'actividad')->only(['index', 'show']);

//Noticias
Route::resource('noticias', NoticiaController::class)->only(['index','show']);

//Cursos
Route::get('/cursos/buscar', [CursoController::class, 'buscar'])->name('centros.buscar');;
Route::resource('cursos', CursoController::class)->only(['index', 'show']);

//Horarios
Route::resource('horarios', HorarioController::class)->only(['index']);

//Valoraciones
Route::resource('valoraciones',ValoracionController::class)->only(['index']);

//Videos
Route::resource('videos',VideoController::class)->only(['index']);

//Beneficio
Route::resource('beneficios', BeneficioController::class)->only(['index']);

//Reservas
Route::resource('reservas',ReservaController::class)->only(['index', 'show']);


//Logeo
Route::get('/login', [ControlController::class, 'create'])->name('login');
Route::post('/login', [ControlController::class, 'store'])->name('login.store');

//Admin
Route::middleware(['auth', 'role:admin'])->group(function () {


    Route::post('/centros/ocultar', [CentroController::class, 'ocultar']);
    Route::resource('centros', CentroController::class)->except(['index','show']);

    //Valoraciones
    Route::resource('valoraciones',ValoracionController::class)->except(['index','show']);

});

//Admin y jefe
Route::middleware(['auth', 'role:admin,jefe'])->group(function () {

    //Usuario

    Route::put('/usuarios/{usuario}/activo', [UsuarioController::class, 'cambiarActivo']);
    
    Route::get('/usuarios/buscar',[UsuarioController::class,'buscar']);
    Route::put('/usuarios/{usuario}/rol',[UsuarioController::class,'cambiarRol']);
    Route::resource('usuarios', UsuarioController::class);

    //Curso
    Route::post('/cursos/ocultar', [CursoController::class, 'ocultar']);
    Route::resource('cursos', CursoController::class)->except(['index','show']);

    //Horario
    Route::resource('horarios', HorarioController::class)->except(['index','show']);

    //Actividad
    Route::post('/actividades/ocultar', [ActividadController::class, 'ocultar']);
    Route::resource('actividades', ActividadController::class)->parameter('actividades', 'actividad')->except(['index','show']);
    
    //Noticia
    Route::post('/noticias/ocultar', [NoticiaController::class, 'ocultar']);
    Route::resource('noticias', NoticiaController::class)->except(['index','show']);

    //Valoracion
    Route::get('/valoracion/create', [ValoracionController::class, 'create'])->name('valoraciones.create');
    Route::post('/valoracion', [ValoracionController::class, 'store'])->name('valoraciones.store');

    //Video
    Route::resource('videos',VideoController::class)->except(['index']);

    //Beneficio
    Route::resource('beneficios', BeneficioController::class)->except(['index','show']);
    Route::get('/beneficios/create/{curso_id}', [BeneficioController::class, 'create'])->name('beneficios.create');
    Route::get('beneficios/biblioteca', [BeneficioController::class, 'biblioteca'])->name('beneficios.biblioteca');
    Route::post('cursos/{curso}/beneficios/asociar', [BeneficioController::class, 'asociar'])->name('cursos.beneficios.asociar');

    //Instalaciones
    Route::get('/instalaciones/buscar',[InstalacionController::class,'buscar']);
    Route::resource('instalaciones',InstalacionController::class)->parameters([
        'instalaciones' => 'instalacion'
    ]);

    //Centros
    Route::resource('centros', CentroController::class)->except(['create', 'store', 'destroy']);

    //reservas
    Route::resource('reservas',ReservaController::class)->except(['index','show']);

    //Sesiones
    Route::resource('sesiones',SesionController::class)->parameters([
        'instalaciones' => 'instalacion'
    ])->except(['index','show']);
});
       
Route::middleware('auth')->group(function () {
    Route::post('/logout', [ControlController::class, 'logout'])->name('logout');;
    Route::get('/profile/history', [ProfileController::class, 'history'])->name('profile.history');
});
    
    
require __DIR__.'/settings.php';