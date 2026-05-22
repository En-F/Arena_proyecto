<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Inscripcion;
use App\Models\Tarifa;
use App\Models\Centro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Hash, Auth, DB};
use Inertia\Inertia;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Http\Requests\StoreSocioRequest;

class SocioController extends Controller
{
    public function create($centro_id = null, $tarifa_id = null)
    {

        $centros = Centro::with('tarifas')->get();

        return Inertia::render('Socio/Inscripcion', [
            'centros' => $centros,
            'centro_id_pre' => $centro_id,
            'tarifa_id_pre' => $tarifa_id,
        ]);
    }

    public function store(StoreSocioRequest $request)
    {
        $datos = $request->validated();

        Stripe::setApiKey(env('STRIPE_SECRET'));
        $tarifa = Tarifa::findOrFail($datos['tarifa_id']);

        if (Auth::check()) {
            $user = Auth::user();
            $nombre   = $user->name;
            $email    = $user->email;
            $password = $user->password;
        } else {
            $nombre   = $datos['name'];
            $email    = $datos['email'];
            $password = Hash::make($datos['password']);
        }

        $session = Session::create([
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => ['name' => "Suscripción: " . $tarifa->nombre],
                    'unit_amount' => $tarifa->precio * 100,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('pago.exito') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url'  => route('pago.cancelado'),
            'metadata' => [
                'name'    =>   $nombre,
                'email'     => $email,
                'dni'       => $datos['dni'],
                'telefono'  => $datos['telefono'],
                'password'  => $password,
                'centro_id' => $datos['centro_id'],
                'tarifa_id' => $datos['tarifa_id'],
            ]
        ]);

        return Inertia::location($session->url);
    }

    private function validarLetraDNI($dni) {
        $letra = strtoupper(substr($dni, -1));
        $numeros = substr($dni, 0, 8);
        return $letra === substr("TRWAGMYFPDXBNJZSQVHLCKE", $numeros % 23, 1);
    }

    public function exito(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $session = \Stripe\Checkout\Session::retrieve([
            'id' => $request->get('session_id'),
            'expand' => ['payment_intent']
        ]);

        $meta = $session->metadata;
        $charge = $session->payment_intent->latest_charge;
        $session = Session::retrieve($request->get('session_id'));
        $receiptUrl = null;


       if ($charge) {
            $chargeData = \Stripe\Charge::retrieve($charge);
            $receiptUrl = $chargeData->receipt_url;
        }

        return DB::transaction(function () use ($meta, $session, $receiptUrl) {
                $user = User::where('email', $meta->email)->first();
                if ($user) {
                    $user->name = $meta->name;
                    $user->dni = $meta->dni;
                    $user->telefono = $meta->telefono;
                    $user->activo = true;
                    $user->save();
                } else {
                    $user = User::create([
                        'name'     => $meta->name,
                        'email'    => $meta->email,
                        'dni'      => $meta->dni,
                        'telefono' => $meta->telefono,
                        'password' => Hash::make($meta->password),
                        'activo'   => true,
                        'fecha_inicio_plataforma' => now(),
                    ]);
                }
            $user->roles()->sync([3]);

            $user->centros()->syncWithoutDetaching([
                $meta->centro_id => [
                    'tarifa_id'    => $meta->tarifa_id,
                    'fecha_alta'   => now(),
                    'fecha_inicio' => $user->fecha_inicio_plataforma ?? now(),
                    'stripe_id'    => $session->id,
                    'factura_url'  => $receiptUrl,
                ]
            ]);

            Auth::login($user);
            return redirect()->route('inicio.index');
        });
    }
}