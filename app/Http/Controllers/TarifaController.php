<?php

namespace App\Http\Controllers;

use App\Models\Tarifa;
use App\Models\Centro;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\tarifas\UpdateTarifaRequest;
use App\Http\Requests\tarifas\StoreTarifaRequest;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class TarifaController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuario_logeado = Auth::user();
        $query = Tarifa::with(['centro', 'inscripciones.usuario']);

        if(!$usuario_logeado->Admin()) {
            $centroIds = $usuario_logeado->centros->pluck('id');
            $query->whereIn('centro_id', $centroIds);
        }
        $tarifas = $query->latest()->get();

        return Inertia::render('Tarifa/index',[
            'tarifas'=> $tarifas
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Tarifa::class);

        $usuario_logeado = Auth::user();
            if($usuario_logeado->Admin()){
                $centros = Centro::all();

            } elseif($usuario_logeado->Jefe()) {
                $centros = $usuario_logeado->centros;
            }  else {
                $centros = [];
            }
        return Inertia::render('Tarifa/create',[
            'centros'=>$centros
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTarifaRequest $request)
    {

        $datos = $request->validated();

        Tarifa::create($datos);

        return redirect()->route('tarifas.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tarifa $tarifa)
    {

        $datos = $request->validated();

        $tarifa->update($datos);


        if ($request->origen === 'index') {
            return redirect()->route('tarifas.index');
        }

        return redirect()->route('centros.show', $tarifa->centro_id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tarifa $tarifa)
    {
        $this->authorize('update', $tarifa);

        return Inertia::render('Tarifa/edit',[
            'tarifa' => $tarifa->load('centro'),
            'from' => request('from'),
            'urlAnterior' => url()->previous() ?: route('tarifas.index'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTarifaRequest $request, Tarifa $tarifa)
    {
        $this->authorize('update', $tarifa);

        $datos = $request->validated();

        $datos['descripcion'] = array_map('trim', explode(',', $request->descripcion));

        $tarifa->update($datos);


        if ($request->origen === 'index') {
            return redirect()->route('tarifas.index');
        }

        return redirect()->route('centros.show', $tarifa->centro_id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tarifa $tarifa)
    {
        $this->authorize('delete', $tarifa);

        if($tarifa->inscripciones()->exists()) {
            return back();
        } else {
            $tarifa->delete();
        }
    }

    public function buscar(Request $request) {

        $usuario = Auth::user();
        $nombreCentro = $request->query('centro');

        if (empty($nombreCentro)) {
            return response()->json([
                'success' => true,
                'message' => '',
                'data' => []
            ]);
        }

        $query = Tarifa::with(['centro', 'inscripciones.usuario']);

        if ($usuario->Jefe()) {
            $centroIds = $usuario->centros->pluck('id');
            $query->whereIn('centro_id', $centroIds);
        }

        $tarifas = $query->whereHas('centro', function($q) use ($nombreCentro) {
            $q->where('nombre', 'ilike', '%' . $nombreCentro . '%');
        })->get();

        return response()->json([
            'success' => true,
            'message' => $tarifas->isEmpty()
                ? "No se han encontrado tarifas para el centro '$nombreCentro'"
                : "Mostrando tarifas del centro '$nombreCentro'",
            'data' => $tarifas
        ]);

    }
}