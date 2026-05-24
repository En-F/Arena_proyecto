<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Model\Reserva;
use App\Model\User;
use Inertia\Inertia;

class ReservaController extends Controller
{
   public function misreservas()
    {
        $usuario = Auth::user();

        $reservas = $usuario->reservas() 
            ->with(['sesion.actividad', 'sesion.centro', 'sesion.horario'])
            ->latest()
            ->get();

        return Inertia::render('Historial/mis-reservas', [
            'reservas' => $reservas,
            'usuario'  => $usuario->name
        ]);
    }
}
