<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\Curso;
use App\Models\Centro;
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

        $actividades = $query->get();

        if ($centroSeleccionado) {
        $query->whereHas('cursos', function ($q) use ($centroSeleccionado) {
            $q->whereHas('centros', function ($q2) use ($centroSeleccionado) {
                $q2->where('centros.id', $centroSeleccionado);
            });
        });
        }

        if ($cursoSeleccionado) {
            $query->whereHas('cursos', function ($q) use ($cursoSeleccionado) {
                $q->where('cursos.id', $cursoSeleccionado)
                ->where('cursos.es_activo', true);
            });
        }

        return Inertia::render('Reserva/index', [
            'actividades'        => $query->get(),
            'centros'            => $centros_visibles,
            'cursos'             => $cursos,
            'centroSeleccionado' => $centroSeleccionado ? (int) $centroSeleccionado : null,
            'cursoSeleccionado'  => $cursoSeleccionado  ? (int) $cursoSeleccionado  : null,
            'estaAutenticado'    => (bool) $usuario,
            'esAdmin'            => $esAdmin,
            'sinCentro'          => false, 
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
     * Display the specified resource.
     */
    public function show(Reserva $reserva)
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
}
