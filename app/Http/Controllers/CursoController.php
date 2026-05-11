<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CursoController extends Controller
{
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Curso $curso)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Curso $curso)
    {
        //
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
