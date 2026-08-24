<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Webhook;
use Stripe\Exception\SignatureVerificationException;
use UnexpectedValueException;

class StripeWebhookController extends Controller
{
    /**
     * Handle incoming Stripe webhook notifications.
     */
    public function handle(Request $request)
    {
        $endpointSecret = config('services.stripe.webhook_secret');
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $event = null;

        try {
            if (!empty($endpointSecret) && $endpointSecret !== 'whsec_your_webhook_secret' && !empty($sigHeader)) {
                $event = Webhook::constructEvent($payload, $sigHeader, $endpointSecret);
            } else {
                // Parse payload directly if secret is not yet configured or in mock testing
                $event = json_decode($payload);
            }
        } catch (UnexpectedValueException $e) {
            Log::warning('Stripe Webhook: Invalid payload received.');
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch (SignatureVerificationException $e) {
            Log::warning('Stripe Webhook: Invalid signature.');
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        if (!$event) {
            return response()->json(['error' => 'No event payload'], 400);
        }

        $eventType = is_object($event) ? ($event->type ?? null) : null;

        // Handle successful payment checkout session
        if ($eventType === 'checkout.session.completed') {
            $session = $event->data->object;
            $orderId = $session->client_reference_id ?? $session->metadata->order_id ?? null;

            if ($orderId) {
                $order = Order::find($orderId);

                if ($order) {
                    $order->update([
                        'status' => 'processing',
                        'payment_status' => 'paid',
                        'stripe_session_id' => $session->id ?? $order->stripe_session_id,
                    ]);

                    Log::info("Order #{$order->id} payment confirmed via Stripe Checkout. Status set to processing.");
                } else {
                    Log::warning("Stripe Webhook: Order #{$orderId} not found in database.");
                }
            }
        }

        return response()->json(['status' => 'success'], 200);
    }
}
