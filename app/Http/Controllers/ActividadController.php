<?php

namespace App\Http\Controllers;

<<<<<<< HEAD
=======
use App\Models\User;
>>>>>>> fb55ae0 (Intregración de las cookies)
use App\Models\Actividad;
use App\Models\Centro;
use App\Models\Curso;
use App\Models\Tipo;
<<<<<<< HEAD
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;
=======
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
>>>>>>> fb55ae0 (Intregración de las cookies)

class ActividadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $usuario = Auth::user();
<<<<<<< HEAD
        
        if($usuario) {
            $centros_activos = $usuario->centros;

            if ($centros_activos->isEmpty()) {
=======
        $esAdmin = $usuario?->tienePermiso() ?? false;

        if($usuario) {
            $centros_activos = $esAdmin ? Centro::all() : $usuario->centros;
            

            if ($centros_activos->isEmpty() && !$esAdmin) {
>>>>>>> fb55ae0 (Intregración de las cookies)
                return Inertia::render('Actividad/index', [
                    'actividades'       => [],
                    'centros'           => [],
                    'cursos'            => [],
                    'tipos'             => Tipo::all(),
                    'centroSeleccionado'=> null,
                    'cursoSeleccionado' => null,
                    'tipoSeleccionado'  => null,
                    'estaAutenticado'   => true,
<<<<<<< HEAD
                    'sinCentro'         => true, 
=======
                    'sinCentro'         => true,
                    'esAdmin'           => false,
>>>>>>> fb55ae0 (Intregración de las cookies)
                ]);
            }

            $centroSeleccionado= $request->input('centro_id',$centros_activos->first()->id);
<<<<<<< HEAD
            

            //Comprovacion de URL
            if(!$centros_activos->pluck('id')->contains($centroSeleccionado)) {
=======


            //Comprovacion de URL
            if(!$esAdmin && !$centros_activos->pluck('id')->contains($centroSeleccionado)) {
>>>>>>> fb55ae0 (Intregración de las cookies)
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

<<<<<<< HEAD
            return Inertia::render('Actividad/Inicio', [
=======
            return Inertia::render('Actividad/index', [
>>>>>>> fb55ae0 (Intregración de las cookies)
                'actividades'        => $actividades,
                'centros'            => $centros_activos,
                'cursos'             => $cursos_activos,
                'tipos'              => Tipo::all(),
                'centroSeleccionado' => (int) $centroSeleccionado,
                'cursoSeleccionado'  => $cursoSeleccionado ? (int) $cursoSeleccionado : null,
                'tipoSeleccionado'   => $tipoSeleccionado  ? (int) $tipoSeleccionado  : null,
                'estaAutenticado'    => true,
                'sinCentro'          => false,
<<<<<<< HEAD
=======
                'esAdmin'            => $esAdmin,
>>>>>>> fb55ae0 (Intregración de las cookies)
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
<<<<<<< HEAD
              $query = Actividad::with(['cursos', 'tipo']);
=======
            $query = Actividad::with(['cursos', 'tipo']);
>>>>>>> fb55ae0 (Intregración de las cookies)

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
<<<<<<< HEAD
            ]);
        }     

=======
                'esAdmin'            => false,
            ]);
        }
>>>>>>> fb55ae0 (Intregración de las cookies)
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
<<<<<<< HEAD

        $actividad_video=Actividad::with('videos')->findOrFail($id);

        return Inertia::render('Actividad/show', [
            'actividad' => $actividad,
            'videos' => $actividad_video->videos
=======
        $actividad_videos = Actividad::with('videos')->findOrFail($id);

        return Inertia::render('Actividad/show', [
            'actividad' => $actividad,
            'videos'=>$actividad_videos->videos
>>>>>>> fb55ae0 (Intregración de las cookies)
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
<<<<<<< HEAD

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
=======
>>>>>>> fb55ae0 (Intregración de las cookies)
}
