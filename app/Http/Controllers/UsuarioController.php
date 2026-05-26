<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\Centro;
use App\Models\User;
use App\Models\Rol;
use App\Models\Inscripcion;
use App\Http\Requests\BuscarUsuarioRequest;
use App\Http\Requests\usuarios\UpdateUsuarioRequest;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;


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
                $q->whereIn('inscripciones.centro_id', $id_centros);
            });

            $query->with(['centros' => function($q) use ($id_centros) {
                $q->whereIn('centros.id', $id_centros);
            }]);

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
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $usuario)
    {

        $usuarioLogueado = Auth::user();
        $usuarioAEditar = User::with(['roles', 'centros'])->findOrFail($usuario->id);

        if ($usuarioLogueado->Jefe()) {
            $misCentrosIds = $usuarioLogueado->centros->pluck('id')->toArray();
            $usuarioComparteCentro = $usuarioAEditar->centros()->whereIn('centros.id', $misCentrosIds)->exists();

            if (!$usuarioComparteCentro) {
                abort(403, 'No tienes permisos para editar usuarios fuera de tu centro.');
            }
        }

        return Inertia::render('Usuario/edit', [
            'usuario' => $usuarioAEditar
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUsuarioRequest $request, User $usuario)
    {
        $usuario = User::findOrFail($usuario->id);

        $usuario->update($request->validated());

        return redirect()->route('usuarios.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $usuario)
    {
        if (auth()->id() === $usuario->id) {
            return redirect()->back()->with('error', 'No puedes borrar tu propia cuenta.');
        }

        if ($usuario->Admin()) {
            return redirect()->back()->with('error', 'No se puede eliminar a un administrador del sistema.');
        }

        $usuario->delete();

        return redirect()->back();

    }

    public function cambiarRol(Request $request, $id)
{
        $rol = Rol::where('rol', $request->nuevoRol)->firstOrFail();
        $usuario = User::findOrFail($id);

        $usuario->roles()->sync([$rol->id]);

        return back()->with('success', 'Rol actualizado correctamente');
    }

    public function cambiarActivo(Request $request, $id)
    {
        $usuarioLogueado = Auth::user();

        if ($usuarioLogueado->id == $id) {
            return back()->withErrors(['message' => 'No puedes desactivar tu propia cuenta']);
        }

        $tieneSuscripcionVigor = Inscripcion::where('user_id', $id)
            ->where('activo', true)
            ->exists();
        if ($tieneSuscripcionVigor) {
            return redirect()->back()->withErrors([
                'activo' => 'Este usuario tiene una suscripción activa. Cancela la suscripción antes de cambiar su estado manualmente.'
            ]);
        }


        $usuarioAModificar->activo = $request->activo;
        $usuarioAModificar->save();
        return back()->with('success', 'Estado actualizado');
    }

    public function portal()
        {
            Stripe::setApiKey(env('STRIPE_SECRET'));

            if (!Auth::user()->stripe_customer_id) {
                return redirect()->back()->with('error', 'Aún no tienes una suscripción activa.');
            }

            $session = \Stripe\BillingPortal\Session::create([
                'customer'   => Auth::user()->stripe_customer_id,
                'return_url' => route('inicio.index'),
            ]);

            return Inertia::location($session->url);
        }
}