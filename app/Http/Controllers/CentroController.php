<?php

namespace App\Http\Controllers;

use App\Models\Centro;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Requests\centros\StoreCentroRequest;
use App\Http\Requests\centros\UpdateCentroRequest;
use Inertia\Inertia;



class CentroController extends Controller
{
    use AuthorizesRequests;

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
        } else {
            $query->where('es_activo', true);
        }

        return Inertia::render('Centro/index',[
        'centros' =>  $query->inRandomOrder()->get(),
    ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Centro::class);

        return Inertia::render('Centro/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCentroRequest $request)
    {
        $datos = $request->validated();

        $centro = Centro::create([
            'nombre'      => $datos['nombre'],
            'telefono'    => $datos['telefono'],
            'email'       => $datos['email'],
            'direccion'   => $datos['direccion'],
            'descripcion' => $datos['descripcion'],
            'es_activo'   => filter_var($datos['es_activo'], FILTER_VALIDATE_BOOLEAN),
            'latitud'     => $datos['latitud'] ?? null,
            'longitud'    => $datos['longitud'] ?? null,
        ]);

        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $extension = $file->extension();

            $nombre_fichero = $centro->id . '.' . $extension;

            $file->storeAs('centros', $nombre_fichero, 'public');

            $centro->imagen = 'centros/' . $nombre_fichero;
            $centro->save();
        }

        return redirect()->route('inicio.index');
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

        $instalaciones = $centro->instalaciones()->get();

        return Inertia::render('Centro/show',[
            'centro'=>$centro,
            'valoraciones'=>$valoraciones,
            'tarifas'=>$tarifas,
            'instalaciones'=>$instalaciones
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Centro $centro)
    {
        $this->authorize('update', $centro);

        return Inertia::render('Centro/edit',[
            'centro'=>$centro
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCentroRequest $request, Centro $centro)
    {
        $this->authorize('update', $centro);


        $datos = $request->validated();

        unset($datos['imagen']);

        $centro->update($datos);

        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $extension = $file->extension();
            
            $nombre_fichero = $centro->id . '.' . $file->extension();

            $file->storeAs('centros', $nombre_fichero, 'public');

            $centro->imagen = 'centros/' . $nombre_fichero;
            $centro->save();
        }

        return redirect()->route('centros.show', $centro->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Centro $centro)
    {
        $this->authorize('delete', $centro);
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