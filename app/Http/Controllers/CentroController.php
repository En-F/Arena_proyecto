<?php

namespace App\Http\Controllers;

use App\Models\Centro;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CentroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Centro/index',
        [
            'centros' => Centro::all()
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
    public function show(Centro $centro)
    {

        $instalaciones = $centro->instalaciones()->get();
        $tarifas = $centro->tarifas()->get();
        $resenas = $centro->valoraciones()->get();

        return Inertia::render('Centro/show',
        [
            'centro' => $centro
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Centro $centro)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Centro $centro)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Centro $centro)
    {
        //
    }
    public function buscar(Request $request)
    {
        $consulta = $request->query('q');

        $centros = Centro::where('nombre','ilike','%' . $consulta . '%')->get();

        return response()->json($centros);
    }
}
