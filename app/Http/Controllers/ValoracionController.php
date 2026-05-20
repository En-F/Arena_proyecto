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
        $usuario = Auth::user();

       $query = Valoracion::with(['usuario:id,name', 'centro:id,nombre']);

        if ($usuario?->Jefe()) {
            $idsMisCentros = $usuario->centros->pluck('id');
            $query->whereIn('centro_id', $idsMisCentros);
        }

        $valoraciones = $query->latest()->get();

        return Inertia::render('Valoracion/index', [
            'valoraciones' => $valoraciones
        ]);
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

        if (!$usuario->Admin()) {
            if (!$usuario->centros->contains($request->centro_id)) {
                abort(403, 'No perteneces a este centro para poder votar.');
            }
        }

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
        return redirect()->back();
    }

    public function buscar(Request $request)
{
    $user = Auth::user();
    $texto = $request->input('centro');

    $query = Valoracion::with(['usuario:id,name', 'centro:id,nombre']);

    if ($texto) {
        $query->whereHas('centro', function ($q) use ($texto) {
            $q->where('nombre', 'ilike', '%' . $texto . '%');
        });
    }

    if ($user->rol === 'jefe') {
        $misCentrosIds = $user->centros()->pluck('centros.id');

        $query->whereIn('centro_id', $misCentrosIds);
    }

    $resultados = $query->latest()->get();

    if ($resultados->isEmpty()) {
        return response()->json([
            'success' => false,
            'message' => 'No se han encontrado valoraciones para "' . $texto . '"',
            'data' => []
        ]);
    }

    return response()->json([
        'success' => true,
        'message' => 'Se han encontrado ' . $resultados->count() . ' valoraciones.',
        'data' => $resultados
    ]);
}
}