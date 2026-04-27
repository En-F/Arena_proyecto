<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Centro;
use App\Models\Rol;
use Illuminate\Support\Facades\DB;

class UsuarioController extends Controller
{
    public function index(Request $request)
    {
        $usuario = Auth::user();

        $query = User::with(['roles', 'centros']);
        
        if($usuario->Admin()){
                
        } elseif($usuario->Jefe()){

            $id_centros = $usuario->centros->pluck('id')->toArray();
           
            $query->whereHas('centros', function ($query) use ($id_centros) {
                $query->whereIn('inscripcion.centro_id', $id_centros);
            })
            ->get();

            $centros = DB::table('centros')
            ->where('es_activo', '=', true)
            ->get();

        } else {
            abort(403);
        }
        return Inertia::render('Usuario/index', [
        'usuarios' => $query->get(),
        'centros'  => Centro::where('es_activo', true)->get(), 
        'roles'    => Rol::all(),
    ]);
        
    }
}