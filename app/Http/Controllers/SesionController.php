<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sesion;
use App\Http\Requests\sesiones\StoreSesionRequest;
use App\Http\Requests\sesiones\UpdateSesionRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Curso;
use App\Models\Centro;
use App\Models\Actividad;
use App\Models\Horario;
use Inertia\Inertia;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class SesionController extends Controller
{
    use AuthorizesRequests;

    public function store(StoreSesionRequest $request)
    {
        $datos = $request->validated();


        $diaSemanaFecha = date('l', strtotime($request->fecha));

        Sesion::create($datos);

        return redirect()->route('horarios.index');
    }

    public function edit(Sesion $sesion)
    {
        $usuario_logeado = Auth::user();

        $this->authorize('update', $sesion);

        $sesion->load(['centro', 'curso', 'actividad', 'horario']);

        return Inertia::render('Sesion/edit', [
            'sesion'      => $sesion,
            'centros'     => Centro::all(),
            'cursos'      => Curso::with('centros')->get(),
            'actividades' => Actividad::with('cursos')->get(),
            'horarios'    => Horario::all(),
        ]);
    }

    public function update(UpdateSesionRequest $request, Sesion $sesion)
    {
        $this->authorize('update', $sesion);

        $validated = $request->validated();

        $sesion->update($validated);

        return redirect()->route('reservas.index');
    }

    public function destroy(Sesion $sesion)
    {
        $this->authorize('delete', $sesion);

        $reservasActivas = $sesion->reservas()
            ->where('estado', 'confirmada')->count();

        if ($reservasActivas > 0) {
            return redirect()->back()->with('error', 'No se puede eliminar la sesión: aún tiene usuarios con plaza reservada.');
        }

        $sesion->delete();

        return redirect()->route('reservas.index');
    }
}