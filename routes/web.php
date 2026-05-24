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
use App\Http\Controllers\SocioController;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\UserPagoController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

// Route::inertia('/', 'Inicio/index', [
//     'canRegister' => Features::enabled(Features::registration()),
// ])->name('home');

Route::get('/', [InicioController::class, 'index'])->name('home');
Route::get('/inicio', [InicioController::class, 'index'])->name('inicio.index');


// Autenticación
Route::get('/login', [ControlController::class, 'create'])->name('login');
Route::post('/login', [ControlController::class, 'store'])->name('login.store');


// Centros
Route::get('/centros/buscar', [CentroController::class, 'buscar'])->name('centros.buscar');

// Actividades
Route::get('/actividades/buscar', [ActividadController::class, 'buscar'])->name('actividades.buscar');

// Cursos
Route::get('/cursos/buscar', [CursoController::class, 'buscar'])->name('cursos.buscar');

Route::get('/settings/UserQr', function () {
    return Inertia::render('settings/UserQr');
})->middleware(['auth']);

Route::middleware('auth')->group(function () {
    Route::post('/logout', [ControlController::class, 'logout'])->name('logout');
    Route::get('/profile/history', [ProfileController::class, 'history'])->name('profile.history');
    Route::get('/settings/Historial', [ControlController::class, 'historial']);
});

//Contacto
Route::get('/contacto', [ControlController::class, 'contacto'])->name('contacto.inicio');
Route::post('/contacto', [ControlController::class, 'enviarContacto'])->name('contacto.enviar');

//Sobre Nosotros
Route::get('/sobre-nosotros', [ControlController::class, 'nosotros'])->name('nosotros.inicio');


// Formulario (centro y tarifa opcionales)
Route::get('/inscribirse/{centro_id?}/{tarifa_id?}', [SocioController::class, 'create'])->name('socio.create');

// Procesar datos y saltar a Stripe
Route::post('/inscribirse', [SocioController::class, 'store'])->name('socio.store');

// Callbacks de Stripe
Route::get('/pago/exito', [SocioController::class, 'exito'])->name('pago.exito');
Route::get('/pago/cancelado', [SocioController::class, 'cancelado'])->name('pago.cancelado');


Route::resource('valoraciones', ValoracionController::class)->parameters([
    'valoraciones' => 'valoracion'
])->except(['index', 'show']);


Route::resource('valoraciones', ValoracionController::class)->only(['index','create','store']);


Route::post('/stripe/webhook', [WebhookController::class, 'handle']);


Route::middleware(['auth', 'role:admin,jefe'])->group(function () {

    // Usuarios
    Route::put('/usuarios/{usuario}/activo', [UsuarioController::class, 'cambiarActivo']);
    Route::get('/usuarios/buscar', [UsuarioController::class, 'buscar']);
    Route::put('/usuarios/{usuario}/rol', [UsuarioController::class, 'cambiarRol']);
    Route::resource('usuarios', UsuarioController::class)->except(['show']);

    // Cursos (Gestión)
    Route::post('/cursos/ocultar', [CursoController::class, 'ocultar']);
    Route::resource('cursos', CursoController::class)->except(['index', 'show']);

    // Actividades (Gestión)
    Route::post('/actividades/ocultar', [ActividadController::class, 'ocultar']);
    Route::resource('actividades', ActividadController::class)
        ->parameter('actividades', 'actividad')
        ->except(['index', 'show']);

    // Horarios (Gestión)
    Route::resource('horarios', HorarioController::class)->except(['index', 'show']);

    // Noticias
    Route::post('/noticias/ocultar', [NoticiaController::class, 'ocultar']);
    Route::resource('noticias', NoticiaController::class)->except(['index', 'show']);

    // Videos y Beneficios (Gestión)
    Route::resource('videos', VideoController::class)->except(['index']);
    Route::resource('beneficios', BeneficioController::class)->except(['index', 'show']);
    Route::get('/beneficios/create/{curso_id}', [BeneficioController::class, 'create'])->name('beneficios.create');
    Route::get('beneficios/biblioteca', [BeneficioController::class, 'biblioteca'])->name('beneficios.biblioteca');
    Route::post('cursos/{curso}/beneficios/asociar', [BeneficioController::class, 'asociar'])->name('cursos.beneficios.asociar');

    // Instalaciones
    Route::get('/instalaciones/buscar', [InstalacionController::class, 'buscar']);
    Route::resource('instalaciones', InstalacionController::class)->parameters([
        'instalaciones' => 'instalacion'
    ]);

    // Valoraciones
    Route::get('/valoraciones/buscar', [ValoracionController::class, 'buscar']);
    Route::resource('valoraciones', ValoracionController::class)->parameters([
        'valoraciones' => 'valoracion'
    ])->except(['index', 'create', 'store', 'show']);

    // Centros (Edición permitida para Jefes también)
    Route::resource('centros', CentroController::class)->only(['edit', 'update']);

    // Reservas (Gestión)
    Route::resource('reservas', ReservaController::class)->except(['index', 'show']);

    // Sesiones
    Route::resource('sesiones', SesionController::class)->parameters([
        'sesiones' => 'sesion'
    ])->except(['show']);

    // Tarifas
    Route::get('/tarifas/buscar', [TarifaController::class, 'buscar']);
    Route::resource('tarifas', TarifaController::class)->except(['show']);

    //Pago de los usuarios
    Route::get('/usuarios/{usuario}/pagos', [UserPagoController::class, 'show'])->name('usuarios.pagos');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::post('/centros/ocultar', [CentroController::class, 'ocultar']);
    Route::resource('centros', CentroController::class)->except(['index', 'show', 'edit', 'update']);
});

// Centros
Route::resource('centros', CentroController::class)->only(['index', 'show']);

// Actividades
Route::resource('actividades', ActividadController::class)
    ->only(['index', 'show'])
    ->parameter('actividades', 'actividad');

// Cursos
Route::resource('cursos', CursoController::class)->only(['index', 'show']);

// Horarios, Videos, Beneficios
Route::resource('horarios', HorarioController::class)->only(['index']);
Route::resource('videos', VideoController::class)->only(['index']);
Route::resource('beneficios', BeneficioController::class)->only(['index']);
Route::resource('noticias', NoticiaController::class)->only(['index','show']);

// Reservas y Valoraciones
Route::resource('reservas', ReservaController::class)->only(['index', 'show']);
Route::resource('valoraciones', ValoracionController::class)->only(['index']);

Route::middleware('auth')->group(function () {

    //Mis Reservas
    Route::get('/historial-reserva', [ReservaController::class, 'misreservas'])
    ->name('mis-reservas');

    
    Route::post('/logout', [ControlController::class, 'logout'])->name('logout');
    Route::get('/profile/history', [ProfileController::class, 'history'])->name('profile.history');

    // Valoraciones
    Route::resource('valoraciones', ValoracionController::class)->only(['create', 'store']);

    //Portal de suscripciones
    Route::get('/suscripcion/portal', [UsuarioController::class, 'portal'])
    ->name('stripe.portal');
});

require __DIR__.'/settings.php';