<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use App\Models\Centro;
use App\Models\Inicio;
use App\Models\Noticia;
use Illuminate\Http\Request;
<<<<<<< HEAD
use Inertia\Inertia;
=======
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Nette\Utils\Json;
>>>>>>> fb55ae0 (Intregración de las cookies)

class InicioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
<<<<<<< HEAD
=======

        $esAdmin = Auth::check() ? Auth::user()->tienePermiso() : false;

>>>>>>> fb55ae0 (Intregración de las cookies)
        return Inertia::render('Inicio/index',[
        'centros' => Centro::all(),
        'noticias' => Noticia::all(),
        'actividades' => Actividad::all(),
<<<<<<< HEAD
=======
        'esAdmin' => $esAdmin
>>>>>>> fb55ae0 (Intregración de las cookies)
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
<<<<<<< HEAD
=======

    public function register(Request $request)
    {

        return Inertia::render('Inicio/register');

        return response()->json($request,200);

    }
>>>>>>> fb55ae0 (Intregración de las cookies)
}
