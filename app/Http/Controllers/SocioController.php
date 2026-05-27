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
use Illuminate\Support\Facades\Mail;
use App\Mail\UsuarioRegistradoMail;



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
        $centro = Centro::findOrFail($datos['centro_id']);
        $tarifa = Tarifa::findOrFail($datos['tarifa_id']);

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $stripeCustomerId = null;

        if (Auth::check()) {
            $user = Auth::user();
            $nombre   = $user->name;
            $email    = $user->email;
            $password = $user->password;
            $stripeCustomerId = $user->stripe_customer_id;
        } else {
            $nombre   = $datos['name'];
            $email    = $datos['email'];
            $password = $datos['password'];
            $existingUser = User::where('email', $email)->first();
            $userExistente = User::where('email', $email)->first();
                if ($userExistente) {
                    $stripeCustomerId = $userExistente->stripe_customer_id;
                }

        }

        $multiplicador = [
            'mes' => 1,
            'trimestre' => 3,
            'semestre' => 6,
            'año' => 12
        ];

        $meses = $multiplicador[$tarifa->periodo];
        $precioTotalBruto = $tarifa->precio * $meses;

        $descuentoDecimal = $tarifa->descuento / 100;

        $precioFinalEuros = $precioTotalBruto * (1 - $descuentoDecimal);

        $precioEnCentimos = (int) round($precioFinalEuros * 100);

        $params = [
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                   'product_data' => [
                        'name' => "Cuota Mensual: {$tarifa->tipo}",
                        'description' => "Centro: {$centro->nombre}",
                    ],
                    'unit_amount' => $precioEnCentimos,
                    'recurring' => [
                        'interval' => ($tarifa->periodo === 'año') ? 'year' : 'month',
                        'interval_count' => ($tarifa->periodo === 'año') ? 1 : $meses,
                    ],
                ],
                'quantity' => 1,
            ]],
            'mode' => 'subscription',
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
            ],
            'subscription_data' => [
                'metadata' => [
                    'centro_id' => $datos['centro_id'],
                    'tarifa_id' => $datos['tarifa_id'],
                ],
            ],
        ];

        if ($stripeCustomerId) {
            $params['customer'] = $stripeCustomerId;
        } else {
            $params['customer_email'] = $email;
        }

        $session = Session::create($params);

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
        $charge = $session->payment_intent->latest_charge ?? null;
        $receiptUrl = null;


       if ($charge) {
            $chargeData = \Stripe\Charge::retrieve($charge);
            $receiptUrl = $chargeData->receipt_url;
        }

        return DB::transaction(function () use ($meta, $session, $receiptUrl) {
                $user = User::where('email', $meta->email)->first();
                if ($user) {
                    $user->update([
                        'name' => $meta->name,
                        'dni' => $meta->dni,
                        'telefono' => $meta->telefono,
                        'activo' => true,
                        'stripe_customer_id' => $session->customer
                    ]);
                } else {
                    $user = User::create([
                        'name'     => $meta->name,
                        'email'    => $meta->email,
                        'dni'      => $meta->dni,
                        'telefono' => $meta->telefono,
                        'password' => Hash::make($meta->password),
                        'activo'   => true,
                        'fecha_inicio_plataforma' => now(),
                        'stripe_customer_id' => $session->customer
                    ]);
                    $esNuevoUsuario = true;
                }
            $user->roles()->sync([3]);

            Inscripcion::updateOrCreate(
                ['stripe_id' => $session->subscription ?? $session->id],
                [
                    'user_id'      => $user->id,
                    'centro_id'    => $meta->centro_id,
                    'tarifa_id'    => $meta->tarifa_id,
                    'status'       => 'active',
                    'factura_url'  => $receiptUrl,
                    'fecha_alta'   => now(),
                    'fecha_inicio' => now(),
                    'activo'       => true,
                ]
            );

            if ($esNuevoUsuario) {
                Mail::to($user->email)->send(new UsuarioRegistradoMail($user));
            }
            Auth::login($user);
            return redirect()->route('inicio.index');
        });
    }
    public function cancelado(Request $request)
    {
        return redirect()->route('inicio.index');
    }
}