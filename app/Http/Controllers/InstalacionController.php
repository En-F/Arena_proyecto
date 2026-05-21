<?php

namespace App\Http\Controllers;

use App\Models\Instalacion;
use App\Models\Centro;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\instalaciones\StoreInstalacionRequest;
use App\Http\Requests\instalaciones\UpdateInstalacionRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class InstalacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $usuario = Auth::user();

        if ($usuario->Jefe()) {
            $todosLosCentros = $usuario->centros; 
        } else {
            $todosLosCentros = Centro::all(); 
        }

        $instalaciones = Instalacion::with('centros')->get()->map(function ($instalacion) use ($todosLosCentros) {
            
            $centrosConEstado = $todosLosCentros->map(function ($centro) use ($instalacion) {
                $estaActivo = $instalacion->centros->contains($centro->id);

                return [
                    'id' => $centro->id,
                    'nombre' => $centro->nombre, 
                    'estado' => $estaActivo ? 'Activo' : 'Inactivo',
                    'activo' => $estaActivo 
                ];
            });

            return [
                'id' => $instalacion->id,
                'nombre' => $instalacion->nombre,
                'imagen' => $instalacion->imagen, 
                'centros' => $centrosConEstado 
            ];
        });

        return Inertia::render('Instalacion/index', [
            'instalaciones' => $instalaciones
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $usuario_logeado = Auth::user();
        if($usuario_logeado->Admin()){
            $centros = Centro::all();

        } elseif($usuario_logeado->Jefe()) {
            $centros = $usuario_logeado->centros;
        }  else {
            $centros = [];
        }

        return Inertia::render('Instalacion/create',[
            'centros' => $centros,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInstalacionRequest $request)
    {
        $datos = $request->validated();

        DB::transaction(function () use ($request, $datos) {

            $instalacion = Instalacion::create([
                'nombre'    => $request->nombre,
                'imagen'    => 'temp',
                'es_activo' => $request->es_activo,
            ]);

            if ($request->hasFile('imagen')) {
                $extension = $request->file('imagen')->getClientOriginalExtension();
            } else {
                //ICONO
                $extension = pathinfo($request->imagen, PATHINFO_EXTENSION);
            }

            $nombreFichero = "{$instalacion->id}.{$extension}";
            $rutaCompleta = "instalaciones/{$nombreFichero}";

            if ($request->hasFile('imagen')) {
                $request->file('imagen')->storeAs('instalaciones', $nombreFichero, 'public');
            } else {
                //ICONO
                Storage::disk('public')->copy($request->imagen, $rutaCompleta);
            }

            $instalacion->update([
                'imagen' => $rutaCompleta
            ]);

            $instalacion->centros()->sync($datos['centros_ids'] ?? []);
            
        });

       return redirect()->route('instalaciones.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Instalacion $instalacion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Instalacion $instalacion)
    {

        $usuario_logeado = Auth::user();

        $instalacion->load('centros');

        if($usuario_logeado->Admin()){
            $centros = Centro::all();

        } elseif($usuario_logeado->Jefe()) {
            $centros = $usuario_logeado->centros()->get()->toArray();
        }  else {
            $centros = [];
        }

        return Inertia::render('Instalacion/edit', [
            'instalacion' => $instalacion, 
            'centros' => $centros
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInstalacionRequest $request, Instalacion $instalacion)
    {
        $datos = $request->validated();

        DB::transaction(function () use ($request, $datos,$instalacion) {

            $instalacion->update([
                'nombre'    => $request->nombre,
                'es_activo' => $request->es_activo,
            ]);

            if ($request->has('imagen') && $request->imagen !== null) {
                
                if ($request->hasFile('imagen')) {
                    $extension = $request->file('imagen')->getClientOriginalExtension();
                } else {
                    // ICONO 
                    $extension = pathinfo($request->imagen, PATHINFO_EXTENSION);
                }

                $nombreFichero = $instalacion->id . '.' . $extension;
                $rutaCompleta = "instalaciones/$nombreFichero";

                if ($request->hasFile('imagen')) {
                    $request->file('imagen')->storeAs('instalaciones', $nombreFichero, 'public');
                } else {
                    Storage::disk('public')->copy($request->imagen, $rutaCompleta);
                }

                $instalacion->update([
                    'imagen' => $rutaCompleta
                ]);
            
            }
            $instalacion->centros()->sync($datos['centros_ids'] ?? []);
            
        });

       return redirect()->route('instalaciones.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Instalacion $instalacion)
    {
        DB::transaction(function () use ($instalacion) {
        
        if ($instalacion->imagen) {
            $nombreArchivo = pathinfo($instalacion->imagen, PATHINFO_FILENAME);

            if (is_numeric($nombreArchivo)) {
                if (Storage::disk('public')->exists($instalacion->imagen)) {
                    Storage::disk('public')->delete($instalacion->imagen);
                }
            }
        }

        $instalacion->centros()->detach();

        $instalacion->delete();
    });

        return redirect()->route('instalaciones.index');
    }

    public function buscar(Request $request) {

        $usuario = Auth::user();    
        $consulta = $request->query('centro');

        if (empty($consulta)) {
            return response()->json([
                'success' => true,
                'message' => 'No se ingresó ningún término de búsqueda',
                'data' => []
            ]);
        }

        if ($usuario->Jefe()) {
            $todosLosCentros = $usuario->centros; 
        } else {
            $todosLosCentros = Centro::all(); 
        }

        $instalacionesFiltradas = Instalacion::with('centros')
        ->where('nombre', 'ilike', '%' . $consulta . '%')
        ->get()
        ->map(function ($instalacion) use ($todosLosCentros) {
            
            $centrosConEstado = $todosLosCentros->map(function ($centro) use ($instalacion) {
                $estaActivo = $instalacion->centros->contains($centro->id);

                return [
                    'id' => $centro->id,
                    'nombre' => $centro->nombre, 
                    'estado' => $estaActivo ? 'Activo' : 'Inactivo',
                    'activo' => $estaActivo 
                ];
            });

            return [
                'id' => $instalacion->id,
                'nombre' => $instalacion->nombre,
                'imagen' => $instalacion->imagen, 
                'centros' => $centrosConEstado 
            ];
        });

    return response()->json([
        'success' => true,
        'message' => 'Resultados de la búsqueda obtenidos con éxito',
        'data' => $instalacionesFiltradas
    ]);
       
    }
}