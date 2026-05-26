<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Actividad;
use App\Models\Centro;
use App\Models\Curso;
use App\Models\Tipo;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\actividades\StoreActividadRequest;
use App\Http\Requests\actividades\UpdateActividadRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;





class ActividadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $usuario = Auth::user();
        $esAdmin = $usuario?->Admin() ?? false;
        $esJefe = $usuario?->Jefe() ?? false;

        if ($usuario && !$esAdmin && $usuario->centros->isNotEmpty()) {
            $centros_visibles = $usuario->centros;
            $restringido = true;
        } else {
            $centros_visibles = Centro::all();
            $restringido = false;
        }

        $centroSeleccionado = $request->input('centro_id', $centros_visibles->first()?->id);
        $cursoSeleccionado = $request->input('curso_id');
        $tipoSeleccionado  = $request->input('tipo_id');

        
        if ($restringido && !$centros_visibles->pluck('id')->contains($centroSeleccionado)) {
            $centroSeleccionado = $centros_visibles->first()->id;
        }
        
        $query = Actividad::with(['cursos', 'tipo']);

        if (!$esAdmin && !$esJefe) {
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

        if ($tipoSeleccionado) {
            $query->where('tipo_id', $tipoSeleccionado);
        }

        return Inertia::render('Actividad/index', [
            'actividades'        => $query->get(),
            'centros'            => $centros_visibles,
            'cursos'             => $cursos,
            'tipos'              => Tipo::all(),
            'centroSeleccionado' => $centroSeleccionado ? (int) $centroSeleccionado : null,
            'cursoSeleccionado'  => $cursoSeleccionado  ? (int) $cursoSeleccionado  : null,
            'tipoSeleccionado'   => $tipoSeleccionado   ? (int) $tipoSeleccionado   : null,
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
        $usuario_logeado = Auth::user();

        if ($usuario_logeado->Admin()) {
            $cursos = Curso::all();
        } elseif ($usuario_logeado->Jefe()) {
            $cursos = Curso::whereHas('centros', function($query) use ($usuario_logeado) {
                $query->whereIn('centro_id', $usuario_logeado->centros->pluck('id'));
            })->get();
        } else {
            $cursos = [];
        }

        return Inertia::render('Actividad/create', [
            'tipos' => Tipo::all(),
            'cursos' => $cursos,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreActividadRequest $request)
    {
        $datos = $request->validated();

        $actividad = Actividad::create([
            'nombre' => $datos['nombre'],
            'nivel' => $datos['nivel'],
            'descripcion' => $datos['descripcion'],
            'tipo_id' => $datos['tipo_id'],
            'es_activo' => filter_var($datos['es_activo'], FILTER_VALIDATE_BOOLEAN),
        ]);

        if(!empty($datos['cursos_ids'])) {
            $actividad->cursos()->sync($datos['cursos_ids']);
        }

        if($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $extension = $file->extension();

            $nombre_fichero = $actividad->id . '.' . $extension;

            $file->storeAs('actividades', $nombre_fichero, 'public');

            $actividad->imagen = 'actividades/' . $nombre_fichero;
            $actividad->save();
        }

        return redirect()->route('inicio.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(Actividad $actividad)
    {
        $id = $actividad->id;
        $actividad_videos = Actividad::with('videos')->findOrFail($id);

        return Inertia::render('Actividad/show', [
            'actividad' => $actividad,
            'videos'=>$actividad_videos->videos
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Actividad $actividad)
    {
        $usuario_logeado = Auth::user();

        $actividad->load('cursos');

        if($usuario_logeado->Admin()){
            $cursos = Curso::all();

        } elseif($usuario_logeado->Jefe()) {
           $centrosIds = $usuario_logeado->centros()->pluck('centros.id')->toArray();

            $cursos = Curso::whereHas('centros', function ($query) use ($centrosIds) {
                $query->whereIn('centros.id', $centrosIds);
            })->get()->toArray();
        }  else {
            $cursos = [];
        }

        return Inertia::render('Actividad/edit',[
            'actividad'=> $actividad,
            'cursos' => $cursos,
            'tipos' => Tipo::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateActividadRequest $request, Actividad $actividad)
    {
        $datos = $request->validated();

        unset($datos['imagen']);

        $actividad->update($datos);

        if(!empty($datos['cursos_ids'])) {
            $actividad->cursos()->sync($datos['cursos_ids']);
        }

        if($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $extension = $file->extension();

            $nombre_fichero = $actividad->id . '.' . $extension;

            $file->storeAs('actividades', $nombre_fichero, 'public');

            $actividad->imagen = 'actividades/' . $nombre_fichero;
            $actividad->save();
        }
        return redirect()->route('actividades.show', $actividad->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Actividad $actividad)
    {
        if ($actividad->imagen) {
            Storage::disk('public')->delete($actividad->imagen);
        }

        $actividad->cursos()->detach();
        $actividad->delete();

        return redirect()->route('inicio.index');
    }

    public function ocultar (Request $request)
    {
        $request->validate(['id' => 'required|exists:actividades,id']);

        $user = Auth::user();
        $actividad = Actividad::findOrFail($request->id);


        if ($actividad) {
            $actividad->update([
                'es_activo' => !$actividad->es_activo
            ]);
    }
        return back();
    }
}
