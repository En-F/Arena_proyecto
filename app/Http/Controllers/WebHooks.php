<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Webhook;
use Stripe\Event;
use App\Models\User;
use App\Models\Inscripcion;
use Illuminate\Support\Facades\Log;

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

        $user = $inscripcion->user;
        $user->activo = $status;
        $user->save();

        Log::info("Usuario {$user->email} " . ($status ? 'activado' : 'desactivado'));
    }
}