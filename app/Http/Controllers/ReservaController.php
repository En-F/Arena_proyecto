<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\Curso;
use App\Models\Centro;
use App\Models\Sesion;
use App\Models\Tarifa;
use App\Models\Inscripcion;
use App\Models\Actividad;
use Carbon\Carbon;

class ReservaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $usuario = auth()->user();
        $usuarioId = auth()->id();
        $esAdmin = $usuario?->Admin() ?? false;

        if ($usuario && !$esAdmin && $usuario->centros->isNotEmpty()) {
            $centros_visibles = $usuario->centros;
            $restringido = true;
        } else {
            $centros_visibles = Centro::all();
            $restringido = false;
        }

        $centroSeleccionado = $request->input('centro_id', $centros_visibles->first()?->id);
        $cursoSeleccionado = $request->input('curso_id');

        if ($restringido && $centroSeleccionado && !$centros_visibles->pluck('id')->contains($centroSeleccionado)) {
            $centroSeleccionado = $centros_visibles->first()->id;
        }

        $cursos = $centroSeleccionado
            ? Curso::whereHas('centros', function ($q) use ($centroSeleccionado) {
                $q->where('centros.id', $centroSeleccionado);
            })->get()
            : Curso::all();

        $querySesiones = Sesion::with(['actividad', 'horario', 'centro', 'curso'])
            ->withCount(['reservas' => function ($q) {
                $q->where('estado', 'confirmada');
            }])
            ->withExists(['reservas' => function ($q) use ($usuarioId) {
                $q->where('user_id', $usuarioId)
                ->where('estado', 'confirmada');
            }]);

        if ($centroSeleccionado) {
            $querySesiones->where('centro_id', $centroSeleccionado);
        }

        if ($cursoSeleccionado) {
            $querySesiones->where('curso_id', $cursoSeleccionado);
        }

        $sesiones = $querySesiones->get();

        $sesionesAgrupadas = $sesiones->groupBy(function($item) {
            try {
                $fechaLimpia = str_replace('/', '-', $item->fecha);
                return \Carbon\Carbon::parse($fechaLimpia)->format('Y-m-d');
            } catch (\Exception $e) {
                return 'error';
            }
        });

        $reservas = Reserva::with(['user', 'sesion.actividad', 'sesion.centro', 'sesion.curso'])
        ->when(!$esAdmin, function($q) use ($usuarioId) {
            return $q->where('user_id', $usuarioId);
        })
        ->latest()
        ->get();

        return Inertia::render('Reserva/index', [
            'sesionesAgrupadas'  => $sesionesAgrupadas,
            'centros'            => $centros_visibles,
            'cursos'             => $cursos,
            'centroSeleccionado' => $centroSeleccionado ? (int) $centroSeleccionado : null,
            'cursoSeleccionado'  => $cursoSeleccionado ? (int) $cursoSeleccionado : null,
            'esAdmin'            => $esAdmin,
            'reservas'           => $reservas,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Sesion $sesion)
    {
        $usuario = Auth::user();

        if (!$usuario->activo) {
            return redirect()->route('reservas.index')
                ->with('error', 'Tu cuenta está inactiva. Por favor, regulariza tu suscripción.');
        }

        $inscripcion = Inscripcion::where('user_id', $usuario->id)->where('activo', true)
        ->where('centro_id', $sesion->centro_id)->first();

        if (!$inscripcion) {
            return redirect()->route('reservas.index')
            ->with('error', 'No tienes una suscripción activa para este centro.');
        }


        $tarifa = Tarifa::find($inscripcion->tarifa_id);

        $inicioSesion = Carbon::parse($sesion->horario->hora_inicio)->format('H:i');
        $inicioTarifa = Carbon::parse($tarifa->hora_inicio)->format('H:i');
        $finTarifa    = Carbon::parse($tarifa->hora_fin)->format('H:i');
        $inicioSemana = now()->startOfWeek();
        $finSemana    = now()->endOfWeek();

        if ($inicioSesion < $inicioTarifa || $inicioSesion > $finTarifa) {
            return redirect()->route('reservas.index')
                ->with('error', "Tu tarifa ({$tarifa->tipo}) no permite reservar a las {$inicioSesion}.");
        }

        $reservasEsteCentroEstaSemana = Reserva::where('user_id', $usuario->id)
            ->where('estado', 'confirmada')
            ->whereBetween('created_at', [$inicioSemana, $finSemana])
            ->whereHas('sesion', function ($query) use ($sesion) {
                $query->where('centro_id', $sesion->centro_id);
            })
            ->count();


        return inertia('Reserva/create', [
            'sesion' => $sesion->load(['actividad', 'horario', 'centro']),
            'tarifa' => $tarifa,
            'usuario' => $usuario,
            'reservas_actuales' => $reservasEsteCentroEstaSemana,
            'limite_reservas'   => $tarifa->reservas_semanales
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Sesion $sesion)
    {
        $usuario = Auth::user();

        $inscripcion = Inscripcion::where('user_id', $usuario->id)
            ->where('centro_id', $sesion->centro_id)
            ->where('activo', true)
            ->first();

        if (!$inscripcion) {
            return redirect()->route('reservas.index')
                ->with('error', 'No tienes una suscripción activa en este centro.');
            }

        $tarifa = Tarifa::find($inscripcion->tarifa_id);

        $inicioSesion = Carbon::parse($sesion->horario->hora_inicio)->format('H:i');
        $inicioTarifa = Carbon::parse($tarifa->hora_inicio)->format('H:i');
        $finTarifa    = Carbon::parse($tarifa->hora_fin)->format('H:i');

        if ($inicioSesion < $inicioTarifa || $inicioSesion > $finTarifa) {
            return redirect()->route('reservas.index')
                ->with('error', "Tu tarifa ({$tarifa->nombre}) no permite reservar a las {$inicioSesion}.");
            }

        $yaReservado = Reserva::where('user_id', $usuario->id)
            ->where('sesion_id', $sesion->id)
            ->where('estado', 'confirmada')
            ->exists();

        if ($yaReservado) {
            return redirect()->route('mis-reservas')
                ->with('error', 'Ya tienes una reserva confirmada para esta clase.');
        }

        $reservasActuales = Reserva::where('sesion_id', $sesion->id)
            ->where('estado', 'confirmada')
            ->count();

        $aforoMaximo = $sesion->capacidad;

        if ($reservasActuales >= $aforoMaximo) {
            return redirect()->route('reservas.index')
                ->with('error', "Lo sentimos, la clase de {$sesion->actividad->nombre} ya está completa ({$aforoMaximo}/{$aforoMaximo} plazas).");
        }


        //VALIDACION DE CANTIDAD DE RESERVAS A LA SEMANA
        $inicioSemana = now()->startOfWeek();
        $finSemana    = now()->endOfWeek();

        $reservasEsteCentroEstaSemana = Reserva::where('user_id', $usuario->id)
            ->where('estado', 'confirmada')
            ->whereBetween('created_at', [$inicioSemana, $finSemana]) 
            ->whereHas('sesion', function ($query) use ($sesion) {
                $query->where('centro_id', $sesion->centro_id);
            })
            ->count();

        if ($reservasEsteCentroEstaSemana >= $tarifa->reservas_semanales) {
            return redirect()->route('reservas.index')
                ->with('error', "Has alcanzado tu límite de {$tarifa->reservas_semanales} reservas semanales en el centro {$sesion->centro->nombre}.");
        }

        $reserva = Reserva::where('user_id', $usuario->id)
            ->where('sesion_id', $sesion->id)
            ->first();

        if ($reserva) {
            $reserva->update([
                'estado' => 'confirmada',
                'fecha'  => now(),
            ]);
        } else {
            Reserva::create([
                'user_id'   => $usuario->id,
                'sesion_id' => $sesion->id,
                'estado'    => 'confirmada',
                'fecha'     => now(),
            ]);
        }

        return redirect()->route('mis-reservas')
        ->with('success', '¡Reserva confirmada! Te hemos guardado el sitio.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reserva $reserva)
    {
        $usuario = Auth::user();

        if ($reserva->user_id !== $usuario->id && !$usuario->Admin() && !$usuario->Jefe()) {
            return redirect()->back()->with('error', 'No tienes permiso para cancelar esta reserva.');
        }

        $fechaSesion = Carbon::parse($reserva->sesion->fecha)->format('Y-m-d');
        $horaInicio = $reserva->sesion->horario->hora_inicio;

        $momentoInicio = Carbon::parse($reserva->sesion->fecha)
        ->setTimeFromTimeString($reserva->sesion->horario->hora_inicio);

        if (now()->addHour()->isAfter($momentoInicio)) {
            return redirect()->back()->with('error', 'No puedes cancelar con menos de 1 hora de antelación.');
        }

        $reserva->update(['estado' => 'cancelada']);

        return redirect()->route('mis-reservas')
            ->with('success', 'Reserva cancelada correctamente');
    }

    public function misreservas()
    {
        $usuario = Auth::user();

        $reservas = $usuario->reservas()
        ->with(['sesion' => function($q) {
            $q->withTrashed();
        }, 'sesion.actividad', 'sesion.centro', 'sesion.horario'])
        ->latest()
        ->get();

        return Inertia::render('Historial/mis-reservas', [
            'reservas' => $reservas,
            'usuario'  => $usuario->name
        ]);
    }
}