<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\Curso;
use App\Models\Centro;
use App\Models\Sesion;
use App\Models\Actividad;

class ReservaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $usuario = Auth::user();
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

        
        if ($restringido && !$centros_visibles->pluck('id')->contains($centroSeleccionado)) {
            $centroSeleccionado = $centros_visibles->first()->id;
        }
        
        $query = Actividad::with(['cursos']);

        if (!$esAdmin) {
            $query->where('es_activo', true);
        }

        $cursos = $centroSeleccionado
            ? Curso::whereHas('centros', function ($q) use ($centroSeleccionado) {
                $q->where('centros.id', $centroSeleccionado);
            })->get()
        : Curso::all();

        $querySesiones = Sesion::with(['actividad', 'horario', 'centro','curso'])
            ->withCount('reservas');
        
        
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

        return Inertia::render('Reserva/index', [
            'sesionesAgrupadas'  => $sesionesAgrupadas,
            'centros'            => $centros_visibles,
            'cursos'             => $cursos,
            'centroSeleccionado' => (int) $centroSeleccionado,
            'cursoSeleccionado'  => $cursoSeleccionado ? (int) $cursoSeleccionado : null,
            'esAdmin'            => $esAdmin,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reserva $reserva)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reserva $reserva)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reserva $reserva)
    {
        //
    }

    public function misreservas()
    {
        $usuario = Auth::user();

        $reservas = $usuario->reservas() 
            ->with(['sesion.actividad', 'sesion.centro', 'sesion.horario'])
            ->latest()
            ->get();

        return Inertia::render('Historial/mis-reservas', [
            'reservas' => $reservas,
            'usuario'  => $usuario->name
        ]);
    }
}
