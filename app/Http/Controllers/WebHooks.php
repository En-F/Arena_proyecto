<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Webhook;
use Stripe\Event;
use App\Models\User;
use App\Models\Inscripcion;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class WebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');
        $endpoint_secret = env('STRIPE_WEBHOOK_SECRET');

        try {
            $event = Webhook::constructEvent($payload, $sig_header, $endpoint_secret);
        } catch (\UnexpectedValueException $e) {
            return response()->json(['error' => 'Payload inválido'], 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            return response()->json(['error' => 'Firma inválida'], 400);
        }

        switch ($event->type) {
            case 'invoice.paid':
                $subscriptionId = $event->data->object->subscription;
                $this->updateUserStatus($subscriptionId, true);
                break;

            case 'invoice.payment_failed':
                $subscriptionId = $event->data->object->subscription;
                $this->updateUserStatus($subscriptionId, false);
                break;

            case 'customer.subscription.deleted':
                $subscriptionId = $event->data->object->id;
                $this->updateUserStatus($subscriptionId, false);
                break;
        }

        return response()->json(['status' => 'success']);
    }

    private function updateUserStatus($stripeId, $status)
    {
        $inscripcion = Inscripcion::where('stripe_id', $stripeId)->first();

        if (!$inscripcion) {
            Log::error("No se encontró suscripción con ID: " . $stripeId);
            return;
        }

        $inscripcion->update([
            'activo' => $activo,
            'status' => $stripeStatus,
            'fecha_fin' => ($stripeStatus === 'canceled') ? now() : $inscripcion->fecha_fin,
        ]);

        $user = $inscripcion->user;
        if ($user) {
            $user->activo = $activo;
            $user->save();
            
            Log::info("Webhook: Usuario {$user->email} actualizado a Activo: " . ($activo ? 'SÍ' : 'NO') . " con estado: {$stripeStatus}");
        }
    }

}