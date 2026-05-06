<?php

namespace App\Http\Controllers;

use App\Models\Centro;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class CentroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $usuario_logeado = Auth::user();

        $query = Centro::query();


        if($usuario_logeado && ($usuario_logeado->Admin())){

        } elseif($usuario_logeado && ($usuario_logeado->Jefe())){

            $query->where('es_activo', true)
                    ->whereIn('id', $usuario_logeado->centros->pluck('id'));
        }

        $query->where('es_activo', true);

        return Inertia::render('Centro/index',[
        'centros' =>  $query->inRandomOrder()->get(),
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

        $valoraciones = DB::table('valoraciones')
            ->where('centro_id', $centro->id)
            ->join('users', 'valoraciones.user_id', '=', 'users.id')
            ->select('valoraciones.*', 'users.name as user_name')
            ->get();

        $tarifas = $centro->tarifas()->get();

        return Inertia::render('Centro/show',[
            'centro'=>$centro,
            'valoraciones'=>$valoraciones,
            'tarifas'=>$tarifas
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

    public function ocultar(Request $request)
    {
        $request->validate([
        'id' => 'required|exists:centros,id'
        ]);

        $centro = Centro::findOrFail($request->id);

        $centro->update(['es_activo' => !$centro->es_activo]);
        $centro->save();

        return back();
    }
}
