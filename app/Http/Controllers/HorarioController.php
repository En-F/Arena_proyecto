<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\Curso;
use App\Models\User;
use App\Models\Centro;
use App\Models\Sesion;
use App\Models\Reserva;
use App\Models\Actividad;


class HorarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $usuario = Auth::user();

        $query = User::with('centros');
        $reservasQuery = Reserva::with(['user', 'sesion.actividad']);

        if($usuario?->Admin()){
            $centrosVisibles = Centro::where('es_activo', true)->with(['cursos.actividades'])->get();
        } elseif($usuario?->Jefe()){

           $id_centros = $usuario->centros->pluck('id')->toArray();

           $centrosVisibles = Centro::whereIn('id', $id_centros)
            ->where('es_activo', true)
            ->with(['cursos.actividades'])
            ->get();

            $reservasQuery->whereHas('sesion', function($q) use ($id_centros) {
                $q->whereIn('centro_id', $id_centros);
            });

        } else {
            abort(403);
        }

        $sesiones = Sesion::with(['horario', 'centro', 'actividad', 'curso'])
            ->latest()
            ->get();

        return Inertia::render('Horario/index', [
            'horarios' => Horario::all(),
            'sesiones' => $sesiones,
            'centros'  => $centrosVisibles,
            'reservas' => $reservasQuery->get()
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $datos = $request->validate([
            'dia'  => 'required|in:lunes,martes,miercoles,jueves,viernes',
            'hora_inicio'   => 'required|date_format:H:i',
            'hora_fin'      => 'required|date_format:H:i|after:hora_inicio',
        ]);

        $horario = Horario::create($datos);

        return redirect()->route('horarios.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Horario $horario)
    {
        $horario->delete();
        return redirect()->route('horarios.index');
    }
}