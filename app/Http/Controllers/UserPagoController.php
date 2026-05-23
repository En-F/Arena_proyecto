<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class UserPagoController extends Controller

{
    public function show(User $usuario) 
    {
        $usuario_logeado = Auth::user();

        if ($usuario->Admin() || $usuario->Jefe()) {
            abort(403, 'No se permite consultar los pagos de usuarios con roles de gestión.');
        }

        $misCentrosIds = [];
        $misCentrosNombres = [];
        
        if ($usuario_logeado->Jefe()) {
            $misCentrosIds = $usuario_logeado->centros->pluck('id')->toArray();
            $misCentrosNombres = $usuario_logeado->centros->pluck('nombre')->toArray();            

            $pertenece = $usuario->centros()
                ->whereIn('centro_id', $misCentrosIds)
                ->exists();

            if (!$pertenece) {
                abort(403, 'No tienes permiso para ver los pagos de este usuario.');
            }

            $usuario->load(['centros' => function($query) use ($misCentrosIds) {
                $query->whereIn('centro_id', $misCentrosIds)->with('tarifas');
            }]);
        } else {
            $usuario->load('centros.tarifas');
        }

        Stripe::setApiKey(env('STRIPE_SECRET'));
        $pagosFinales = [];

        if ($usuario->stripe_customer_id) {
            $stripePayments = PaymentIntent::all([
                'customer' => $usuario->stripe_customer_id,
                'limit' => 20,
                'expand' => ['data.latest_charge']
            ]);

            $pagosDatos = $stripePayments->data;

            if ($usuario_logeado->is_jefe) {
                $pagosDatos = array_filter($pagosDatos, function($pago) use ($misCentrosIds, $misCentrosNombres) {
                    $centroIdMetadata = isset($pago->metadata->centro_id) ? (int)$pago->metadata->centro_id : null;
                    if ($centroIdMetadata && in_array($centroIdMetadata, $misCentrosIds)) {
                        return true;
                    }

                    $descripcion = $pago->latest_charge->description ?? '';
                    foreach ($misCentrosNombres as $nombre) {
                        if (!empty($nombreLimpio) && str_contains($descripcion, $nombreLimpio)) {
                            return true;
                        }
                    }

                    return false;
                });
            }

            $pagosFinales = array_map(function($pago) {
                $urlArchivo = null;
                
                if (!empty($pago->invoice)) {
                    try {
                        $invoice = \Stripe\Invoice::retrieve($pago->invoice);
                        $urlArchivo = $invoice->invoice_pdf;
                    } catch (\Exception $e) {
                        $urlArchivo = null;
                    }
                }

                if (!$urlArchivo && isset($pago->latest_charge->receipt_url)) {
                    $urlArchivo = $pago->latest_charge->receipt_url;
                }

                $pago->invoice_pdf = $urlArchivo;
                return $pago;
            }, (array)$pagosDatos);
        }


        return Inertia::render('Usuario/pagos', [
            'usuario' => $usuario,
            'pagos'   => array_values($pagosFinales),
        ]);
    }
}