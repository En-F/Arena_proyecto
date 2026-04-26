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

        $esAdmin = $usuario?->Admin() ?? false;
        $esJefe = $usuario?->Jefe() ?? false;

        $id_centros = $usuario->centros->pluck('id')->toArray();

        if($esAdmin){
            $usuarios =User::with('roles','centros')->get();
            $centros = DB::table('centros')
            ->where('es_activo', '=', true)
        ->get();
        } elseif ($esJefe){
            $usuarios =User::with('roles','centros')->get();
            $centros = DB::table('centros')
            ->where('es_activo', '=', true)
            ->get();
        }


        

        
        return Inertia::render('Usuario/index',
        [
            'usuarios' => $usuarios,
            'centros' =>$centros,
            'roles'    => Rol::all(),
        ]);
    }
}