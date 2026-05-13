<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Centro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\cursos\StoreCursoRequest;
use App\Http\Requests\cursos\UpdateCursoRequest;
use Inertia\Inertia;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;


class CursoController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $user = Auth::user();

        if($user && $user->Admin()) {
            $cursos = Curso::all();
        } elseif($user && $user->Jefe()){
           $cursos = Curso::whereHas('centros', function ($query) use ($user) {
                $query->whereIn('centros.id', $user->centros->pluck('id'));
            })->get();
        } else {
            $cursos = Curso::where('es_activo', true)->get();
        }

        return Inertia::render('Curso/index', [
            'cursos' => $cursos
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $this->authorize('create', Curso::class);

        $usuario_logeado = Auth::user();
        if($usuario_logeado->Admin()){
            $centros = Centro::all();

        } elseif($usuario_logeado->Jefe()) {
            $centros = $usuario_logeado->centros;
        }  else {
            $centros = [];
        }

        return Inertia::render('Curso/create',[
            'centros' => $centros,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCursoRequest $request)
    {


        $datos = $request->validated();

        $curso = Curso::create([
            'nombre' => $datos['nombre'],
            'descripcion' => $datos['descripcion'],
            'es_activo' => filter_var($datos['es_activo'], FILTER_VALIDATE_BOOLEAN),
        ]);

        $curso->centros()->sync($datos['centros_ids'] ?? []);

        if($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $extension = $file->extension();

            $nombre_fichero = $curso->id . '.' . $extension;

            $file->storeAs('cursos', $nombre_fichero, 'public');

            $curso->imagen = 'cursos/' . $nombre_fichero;
            $curso->save();
        }

        return redirect()->route('inicio.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Curso $curso)
    {
        $id = $curso->id;
        $beneficios = Curso::with('beneficios')->findOrFail($id);
        $curso_videos = Curso::with('videos')->findOrFail($id);

        return Inertia::render('Curso/show',[
            'curso'=>$curso,
            'videos'=> $curso_videos->videos,
            'beneficios'=> $curso_videos->beneficios
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Curso $curso)
    {
        $this->authorize('update', $curso);

        $usuario_logeado = Auth::user();

        $curso->load('centros');

        if ($usuario_logeado->Admin()){
            $centros = Centro::all();

        } elseif($usuario_logeado->Jefe()) {
            $centros = $usuario_logeado->centros()->get()->toArray();
        } else {
            $centros = [];
        }


        return Inertia::render('Curso/edit',[
            'curso' => $curso,
            'centros' => $centros
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCursoRequest $request, Curso $curso)
    {

        $this->authorize('update', $curso);

        $datos = $request->validated();

        $curso->update([
            'nombre'    => $datos['nombre'],
            'descripcion' => $datos['descripcion'],
        ]);


        $curso->centros()->sync($datos['centros_ids'] ?? []);

        if($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $extension = $file->extension();

            $nombre_fichero = $curso->id . '.' . $extension;

            $file->storeAs('cursos', $nombre_fichero, 'public');

            $curso->imagen = 'cursos/' . $nombre_fichero;
        }

        $curso->save();

        return redirect()->route('cursos.show', $curso->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Curso $curso)
    {
        $this->authorize('delete', $curso);

        if ($curso->imagen) {
            if (Storage::disk('public')->exists($curso->imagen)) {
                Storage::disk('public')->delete($curso->imagen);
            }
        }

        $curso->delete();

        return redirect()->route('inicio.index');

    }
    public function buscar(Request $request)
    {
        $consulta = $request->query('q');

        $cursos = Curso::where('nombre','ilike','%' . $consulta . '%')->get();

        return response()->json($cursos);
    }

    public function ocultar(Request $request)
{
    $request->validate(['id' => 'required|exists:cursos,id']);

    $user = Auth::user();
    $curso = Curso::findOrFail($request->id);

    if ($user->Admin()) {
        $curso->update(['es_activo' => !$curso->es_activo]);
        return back()->with('success', 'Curso ocultado correctamente.');
    }

    if ($user->Jefe()) {
        $misCentrosIds = $user->centros->pluck('id')->toArray();

        $tienePermiso = $curso->centros()
                              ->whereIn('centros.id', $misCentrosIds)
                              ->exists();

        if ($tienePermiso) {
            $curso->update(['es_activo' => !$curso->es_activo]);
            return back();
        }
    }

    abort(403, 'No tienes permiso para ocultar este curso.');
}
}
