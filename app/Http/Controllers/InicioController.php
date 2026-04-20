<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use App\Models\Centro;
use App\Models\Inicio;
use App\Models\Noticia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Nette\Utils\Json;

class InicioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $esAdmin = Auth::check() ? Auth::user()->tienePermiso() : false;

        return Inertia::render('Inicio/index',[
        'centros' => Centro::all(),
        'noticias' => Noticia::all(),
        'actividades' => Actividad::all(),
        'esAdmin' => $esAdmin
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
    public function show(Inicio $inicio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inicio $inicio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inicio $inicio)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inicio $inicio)
    {
        //
    }

    public function register(Request $request)
    {

        return Inertia::render('Inicio/register');

        return response()->json($request,200);

    }
}
