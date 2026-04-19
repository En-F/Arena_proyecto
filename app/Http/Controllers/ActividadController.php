<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use App\Models\Centro;
use App\Models\Curso;
use App\Models\Tipo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ActividadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $usuario = Auth::user();
        
        if($usuario) {
            $centros_activos = $usuario->centros;

            if ($centros_activos->isEmpty()) {
                return Inertia::render('Actividad/index', [
                    'actividades'       => [],
                    'centros'           => [],
                    'cursos'            => [],
                    'tipos'             => Tipo::all(),
                    'centroSeleccionado'=> null,
                    'cursoSeleccionado' => null,
                    'tipoSeleccionado'  => null,
                    'estaAutenticado'   => true,
                    'sinCentro'         => true, 
                ]);
            }

            $centroSeleccionado= $request->input('centro_id',$centros_activos->first()->id);
            

            //Comprovacion de URL
            if(!$centros_activos->pluck('id')->contains($centroSeleccionado)) {
                $centroSeleccionado = $centros_activos->first()->id;
            }

            $cursos_activos = Curso::whereHas('centros', function ($q) use ($centroSeleccionado) {
                $q->where('centros.id', $centroSeleccionado);
            })->get();

            $cursos_activos_ID = $cursos_activos->pluck('id');

            $cursoSeleccionado = $request->input('curso_id');
            $tipoSeleccionado  = $request->input('tipo_id');

            $query = Actividad::with(['cursos', 'tipo']);

            if ($cursoSeleccionado && $cursos_activos_ID->contains($cursoSeleccionado)) {
                $query->whereHas('cursos', function($q) use ($cursoSeleccionado) {
                    $q->where('cursos.id', $cursoSeleccionado);
                });
            } else {
                $query->whereHas('cursos', function($q) use ($cursos_activos_ID) {
                    $q->whereIn('cursos.id', $cursos_activos_ID);
                });
            }

            if ($tipoSeleccionado) {
                $query->where('tipo_id', $tipoSeleccionado);
            }

            $actividades = $query->get();

            return Inertia::render('Actividad/Inicio', [
                'actividades'        => $actividades,
                'centros'            => $centros_activos,
                'cursos'             => $cursos_activos,
                'tipos'              => Tipo::all(),
                'centroSeleccionado' => (int) $centroSeleccionado,
                'cursoSeleccionado'  => $cursoSeleccionado ? (int) $cursoSeleccionado : null,
                'tipoSeleccionado'   => $tipoSeleccionado  ? (int) $tipoSeleccionado  : null,
                'estaAutenticado'    => true,
                'sinCentro'          => false,
            ]);
        }  else {
            $centroId = $request->input('centro_id');
            $cursoId  = $request->input('curso_id');
            $tipoId   = $request->input('tipo_id');

            // N:M Centro ↔ Curso
            $cursos = $centroId
                ? Curso::whereHas('centros', function ($q) use ($centroId) {
                    $q->where('centros.id', $centroId);
                })->get()
                : Curso::all();

            // N:M Curso ↔ Actividad
              $query = Actividad::with(['cursos', 'tipo']);

              if ($centroId) {
                // Actividad → Curso → Centro
                $query->whereHas('cursos', function ($q) use ($centroId) {
                    $q->whereHas('centros', function ($q2) use ($centroId) {
                        $q2->where('centros.id', $centroId);
                    });
                });

                if ($cursoId) {
                    $query->whereHas('cursos', function ($q) use ($cursoId) {
                        $q->where('cursos.id', $cursoId);
                    });
                }

                if ($tipoId) {
                    $query->where('tipo_id', $tipoId);
                }
            }

            return Inertia::render('Actividad/index', [
                'actividades'        => $query->get(),
                'centros'            => Centro::all(),
                'cursos'             => $cursos,
                'tipos'              => Tipo::all(),
                'centroSeleccionado' => $centroId ? (int) $centroId : null,
                'cursoSeleccionado'  => $cursoId  ? (int) $cursoId  : null,
                'tipoSeleccionado'   => $tipoId   ? (int) $tipoId   : null,
                'estaAutenticado'    => false,
                'sinCentro'          => false,
            ]);
        }     

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
    public function show(Actividad $actividad)
    {
        $id = $actividad->id;

        $actividad_video=Actividad::with('videos')->findOrFail($id);

        return Inertia::render('Actividad/show', [
            'actividad' => $actividad,
            'videos' => $actividad_video->videos
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Actividad $actividad)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Actividad $actividad)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Actividad $actividad)
    {
        //
    }

    public function buscar(Request $request)
    {
        $centros = Centro::all();
        $tipos = Tipo::all();

        $query = Actividad::query();

        if ($request->filled('nombre')) {
            $query->where('nombre', 'like', '%' . $request->nombre . '%');
        }

        if ($request->filled('centro_id')) {
            $query->where('centro_id', $request->centro_id);
        }

        if ($request->filled('tipo_id')) {
            $query->where('tipo_id', $request->tipo_id);
        }

        return Inertia::render('Actividad/index', [
            'actividades' => $query->get(),
            'centros' => $centros,
            'tipos' => $tipos,
        ]);
    }
}
