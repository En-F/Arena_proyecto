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
use App\Http\Controllers\TarifaController;
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



//Cursos
Route::get('/cursos/buscar', [CursoController::class, 'buscar'])->name('centros.buscar');;

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

//Valoraciones
Route::resource('valoraciones',ValoracionController::class)->only(['create','store']);


//Logeo
Route::get('/login', [ControlController::class, 'create'])->name('login');
Route::post('/login', [ControlController::class, 'store'])->name('login.store');

//Admin
Route::middleware(['auth', 'role:admin'])->group(function () {


    Route::post('/centros/ocultar', [CentroController::class, 'ocultar']);
    Route::resource('centros', CentroController::class)->except(['index','show']);


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
    Route::resource('cursos', CursoController::class);

    //Horario
    Route::resource('horarios', HorarioController::class)->except(['index','show']);

    //Actividad
    Route::post('/actividades/ocultar', [ActividadController::class, 'ocultar']);
    Route::resource('actividades', ActividadController::class)
            ->parameter('actividades', 'actividad');    
    //Noticia
    Route::post('/noticias/ocultar', [NoticiaController::class, 'ocultar']);
    Route::resource('noticias', NoticiaController::class);


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

    //Valoraciones
    Route::resource('valoraciones',ValoracionController::class)->parameters([
        'valoraciones' => 'valoracion'
    ])->except(['show']);

    //Centros
    Route::resource('centros', CentroController::class)->only(['edit', 'update']);
    
    //reservas
    Route::resource('reservas',ReservaController::class)->except(['index','show']);

    //Sesiones
    Route::resource('sesiones',SesionController::class)->parameters([
        'instalaciones' => 'instalacion'
    ])->except(['index','show']);

    //tarifas
    Route::get('/tarifas/buscar',[TarifaController::class,'buscar']);
    Route::resource('tarifas',TarifaController::class)->except(['show']);


});
       
Route::middleware('auth')->group(function () {
    Route::post('/logout', [ControlController::class, 'logout'])->name('logout');;
    Route::get('/profile/history', [ProfileController::class, 'history'])->name('profile.history');
});
    
    
require __DIR__.'/settings.php';