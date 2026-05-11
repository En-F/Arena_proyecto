<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use App\Models\Curso;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Carbon\Carbon;



class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $actividad_id = $request->query('actividad_id');
        $curso_id = $request->query('curso_id');
    
        return Inertia::render('Video/create',[
            'actividad_id' => $actividad_id,
            'curso_id' => $curso_id
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $datos = $request->validate([
        'titulo'    => ['required', 'string', 'max:255', 'regex:/^[a-zA-ZÀ-ÿ\s\'"]+$/'],
        'url' => ['required', 'string'],
        'regresar_a_id' => 'required',
        'tipo'   => 'required|in:actividad,curso'
       ]);

       $video = Video::create([
           'titulo' => $datos['titulo'],
           'url' => $datos['url'],
        ]);
           
        $tipoPadre = null;

        $tipo = $request->tipo;
        if ($tipo === 'actividad') {
            $tipoPadre = \App\Models\Actividad::class;
        } elseif ($tipo === 'curso') {
            $tipoPadre = \App\Models\Curso::class;
        } else {
            return back();
        }

        $idPadre = $request->regresar_a_id;
        
        $modeloPadre = $tipoPadre::findOrFail($idPadre);
        $modeloPadre->videos()->attach($video->id);

        $ruta = ($tipo === 'actividad') ? 'actividades.show' : 'cursos.show';

        return redirect()->route($ruta, $idPadre);
    }

    /**
     * Display the specified resource.
     */
    public function show(Video $video)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Video $video)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Video $video)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Video $video)
    {
        $idPadre = $request ->input('regresar_a_id');
        $tipoPadre = $request->input('tipo');

        $video->delete();

        if ($tipoPadre === 'actividad') {
            return redirect()->route('actividades.show', $idPadre);
        }

        if ($tipoPadre === 'curso') {
            return redirect()->route('cursos.show', $idPadre);
        }

        return back()->with('success', 'Vídeo eliminado');

    }
}
