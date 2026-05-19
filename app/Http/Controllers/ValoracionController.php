<?php

namespace App\Http\Controllers;

use App\Models\Valoracion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Centro;
use Inertia\Inertia;




class ValoracionController extends Controller
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
        $centroId = $request->query('centro_id');
        $centro = Centro::findOrFail($centroId);

        return Inertia::render('Valoracion/create', [
            'centro' => $centro
        ]);    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $usuario = Auth::user();

        $datos = $request->validate([
            'puntuacion'=> 'required|numeric|',
            'titulo' => 'required|string|',
            'comentario' => 'required|string|max:255|',
            'centro_id' => 'required|exists:centros,id',
        ]);
        $datos['user_id'] = $usuario->id;
            
        Valoracion::create($datos);

        return redirect()->route('centros.show',$datos['centro_id']);

    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Valoracion $valoracion)
    {
        $centro = $valoracion->centro_id;
        $valoracion->delete();
        return redirect()->route('centros.show',$centro);
    }
}
