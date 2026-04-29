<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Centro;
use App\Models\Rol;
use App\Http\Requests\BuscarUsuarioRequest;
use Illuminate\Support\Facades\DB;

class UsuarioController extends Controller
{
    public function index(Request $request)
    {
        $usuario = Auth::user();

        $query = User::with(['roles', 'centros']);

        if($usuario->Admin()){
            $centrosVisibles = Centro::where('es_activo', true)->get();
        } elseif($usuario->Jefe()){

            $id_centros = $usuario->centros->pluck('id')->toArray();

            $query->whereHas('centros', function ($q) use ($id_centros) {
                $q->whereIn('inscripcion.centro_id', $id_centros);
            })
            ->get();

            $centrosVisibles = Centro::whereIn('id', $id_centros)
                                 ->where('es_activo', true)
                                 ->get();

        } else {
            abort(403);
        }

        return Inertia::render('Usuario/index', [
            'usuarios' => $query->get(),
            'centros'  => $centrosVisibles,
            'roles'    => Rol::where('rol', '!=', 'admin')->get(),
        ]);

    }
    public function buscar (BuscarUsuarioRequest $request)
    {

        $usuario = Auth::user();
        $datos = $request->validated();

        if (!$usuario->Admin() && !$usuario->Jefe()) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permisos para buscar usuarios',
                'usuarios' => []
            ], 403);
        }

        //Comprobar que ha colocado algun filtro.
        $tieneAlgunFiltro = !empty($datos['nombre']) ||
                           !empty($datos['email']) ||
                           !empty($datos['dni']) ||
                           !empty($datos['centro_id']) ||
                           $request->filled('activo');


        if (!$tieneAlgunFiltro) {
            return response()->json([
                'success' => false,
                'message' => 'Debes introducir al menos un filtro de búsqueda',
                'usuarios' => []
            ]);
        }



        $query = User::with(['roles', 'centros']);

        if ($usuario->Jefe() && !$usuario->Admin()) {
            $query->whereDoesntHave('roles', function($q) {
                $q->where('rol', 'admin');
            });

            $id_centros = $usuario->centros->pluck('id')->toArray();
            $query->whereHas('centros', function ($q) use ($id_centros) {
                $q->whereIn('inscripcion.centro_id', $id_centros);
            });
        }

        if (!empty($datos['nombre'])) {
            $query->where('name', 'ilike', '%' . trim($datos['nombre']) . '%');
        }

        if (!empty($datos['email'])) {
            $query->where('email', 'ilike', '%' . trim($datos['email']) . '%');
        }

        if (!empty($datos['dni'])) {
            $query->where('dni', 'ilike', '%' . trim($datos['dni']) . '%');
        }


        if (!empty($datos['centro_id'])) {
            $query->whereHas('centros', function($q) use ($datos) {
                $q->where('centro_id', $datos['centro_id']);
            });
        }

        if ($request->filled('activo')) { 
            $query->where('activo', $request->boolean('activo'));
        }



        $usuarios = $query->get();

        return response()->json([
            'success' => true,
            'message' => $usuarios->count() > 0
                ? 'Se encontraron ' . $usuarios->count() . ' usuario(s)'
                : 'No se encontraron usuarios con los filtros especificados',
            'usuarios' => $usuarios,
            'filtros_aplicados' => array_filter([
                'nombre' => $datos['nombre'] ?? null,
                'email' => $datos['email'] ?? null,
                'dni' => $datos['dni'] ?? null,
                'centro_id' => $datos['centro_id'] ?? null,
                'activo' => $datos['activo'] ?? null,
            ])
        ]);

    }
}
