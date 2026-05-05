<?php

namespace App\Http\Controllers;

use App\Models\Centro;
use App\Models\Noticia;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreNoticiaRequest;
use App\Http\Requests\UpdateNoticiaRequest;
use Inertia\Inertia;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;


class NoticiaController extends Controller
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
    public function create()
    {
        $usuario_logeado = Auth::user();

        if($usuario_logeado->Admin()) {
            $centros = Centro::all();
        } elseif($usuario_logeado->Jefe()) {
            $centros = DB::table('centros')
                ->join('inscripcion', 'centros.id', '=', 'inscripcion.centro_id')
                ->where('inscripcion.user_id', $usuario_logeado->id)
                ->select('centros.*')
                ->distinct()
                ->get();
        } else {
            return redirect()->route('/login');
        }

        $fecha_actual = User::fecha_actual();

        return Inertia::render('Noticia/create', [
            'centros' => $centros,
            'fecha_actual' => $fecha_actual
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNoticiaRequest $request)
    {
        $data = $request->validated();


        $noticia = new Noticia();
        $noticia->titulo = $data['titulo'];
        $noticia->contenido = $data['contenido'];
        $noticia->centro_id = $data['centro_id'];
        $noticia->fecha = $data['fecha'];
        $noticia->es_activo = $data['es_activo'];
        $noticia->user_id = auth()->id();

        $noticia->save();

        if($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $extension = $file->extension();

            $nombre_fichero = $noticia->id . '.' . $extension;

            $file->storeAs('noticias', $nombre_fichero, 'public');

            $noticia->imagen = '/noticias/' . $nombre_fichero;
            $noticia->save();
        }

        return redirect()->route('inicio.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Noticia $noticia)
    {

        $fecha_formateada = Carbon::parse($noticia->fecha)->locale('es')->translatedFormat('d \d\e F \d\e Y');
        $noticia->fecha = $fecha_formateada;
        $es_activo = $noticia->es_activo;
        $centro = $noticia->centro;

        return Inertia::render('Noticia/show', [
            'noticia' => $noticia,
            'es_activo' => $es_activo,
            'centro' => $centro
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Noticia $noticia)
    {
        return Inertia::render('Noticia/edit', [
            'noticia' => $noticia,
            'centros' => Centro::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNoticiaRequest $request, Noticia $noticia)
    {
        $data = $request->validated();

        $noticia->update([
        'titulo'    => $data['titulo'],
        'contenido' => $data['contenido'],
        'centro_id' => $data['centro_id'],
        'fecha'     => $data['fecha'],
        'user_id'   => auth()->id(),
        ]);

        if($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $extension = $file->extension();

            $nombre_fichero = $noticia->id . '.' . $extension;

            $file->storeAs('noticias', $nombre_fichero, 'public');

            $noticia->imagen = '/noticias/' . $nombre_fichero;
            $noticia->save();
    }

        return redirect()->route('noticias.show', $noticia->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Noticia $noticia)
    {
        if ($noticia->imagen) {
                Storage::disk('public')->delete($noticia->imagen);
            }

            $noticia->delete();

            return redirect()->route('inicio.index');
    }

    public function ocultar(Request $request)
    {
        $request->validate([
        'id' => 'required|exists:noticias,id'
        ]);

        $noticia = Noticia::findOrFail($request->id);

        $noticia->update(['es_activo' => !$noticia->es_activo]);
        $noticia->save();

        return back();
    }
}
