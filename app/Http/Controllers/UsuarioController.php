<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class UsuarioController extends Controller
{
    public function index(Request $request)
    {
        
        $usuarios =User::with('roles','centros')->get();
        
        return Inertia::render('Usuario/index',
        [
            'usuarios' => $usuarios
        ]);
    }
}