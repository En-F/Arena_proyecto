<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use App\Models\Centro;
use App\Models\Inicio;
use App\Models\User;
use App\Models\Noticia;
use App\Models\Curso;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InicioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $usuario_logeado = Auth::user();

        $centrosConsulta = DB::table('centros')->where('es_activo', true);
        $noticiasConsulta = DB::table('noticias')->where('es_activo', true);
        $cursosConsulta = DB::table('cursos')->where('es_activo', true);

        if($usuario_logeado && ($usuario_logeado->Admin())){

            $noticiasConsulta = DB::table('noticias');

        } elseif($usuario_logeado && ($usuario_logeado->Jefe())){

            $centrosConsulta->whereIn('id', $usuario_logeado->centros->pluck('id'));

            $idsCursos = Curso::whereHas('centros', function ($query) use ($usuario_logeado) {
                $query->whereIn('centros.id', $usuario_logeado->centros->pluck('id'));
            })->pluck('id');

            $cursosConsulta->whereIn('id', $idsCursos);

            $noticiasConsulta = DB::table('noticias')
            ->whereIn('id', $usuario_logeado->noticias->pluck('id'));


        }
        return Inertia::render('Inicio/index',[
        'centros' =>  $centrosConsulta->inRandomOrder()->get(),
        'noticias' =>$noticiasConsulta->inRandomOrder()->get(),
        'cursos' => $cursosConsulta->inRandomOrder()->get(),
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
    public function show(Inicio $inicio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inicio $inicio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inicio $inicio)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inicio $inicio)
    {
        //
    }



}
