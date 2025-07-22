<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\StripeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    protected $stripeService;

    public function __construct(StripeService $stripeService)
    {
        $this->stripeService = $stripeService;
    }

    /**
     * Afficher la page de paiement
     */
    public function show(Order $order)
    {
        // Vérifier que l'utilisateur est propriétaire de la commande
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        // Vérifier que la commande n'est pas déjà payée
        if ($order->status === 'paid') {
            return redirect()->route('orders.show', $order)->with('info', 'Cette commande a déjà été payée.');
        }

        // Créer un PaymentIntent
        $result = $this->stripeService->createPaymentIntent($order);

        if (!$result['success']) {
            return back()->with('error', 'Erreur lors de l\'initialisation du paiement: ' . $result['error']);
        }

        return view('payments.show', [
            'order' => $order,
            'clientSecret' => $result['client_secret'],
            'stripeKey' => config('services.stripe.key'),
        ]);
    }

    /**
     * Traiter le paiement
     */
    public function process(Request $request, Order $order)
    {
        // Vérifier que l'utilisateur est propriétaire de la commande
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'payment_intent_id' => 'required|string',
        ]);

        $paymentIntentId = $request->input('payment_intent_id');

        // Confirmer le paiement
        $result = $this->stripeService->confirmPaymentIntent($paymentIntentId);

        if ($result['success']) {
            // Mettre à jour le statut de la commande
            $order->update([
                'status' => 'paid',
                'payment_intent_id' => $paymentIntentId,
                'paid_at' => now(),
            ]);

            // Vider le panier
            session()->forget('cart');

            return redirect()->route('payments.success', $order)
                ->with('success', 'Paiement effectué avec succès !');
        } else {
            Log::error('Erreur de paiement Stripe', [
                'order_id' => $order->id,
                'payment_intent_id' => $paymentIntentId,
                'error' => $result['error'],
            ]);

            return redirect()->route('payments.failure', $order)
                ->with('error', 'Erreur lors du paiement: ' . $result['error']);
        }
    }

    /**
     * Page de succès
     */
    public function success(Order $order)
    {
        // Vérifier que l'utilisateur est propriétaire de la commande
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        return view('payments.success', compact('order'));
    }

    /**
     * Page d'échec
     */
    public function failure(Order $order)
    {
        // Vérifier que l'utilisateur est propriétaire de la commande
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        return view('payments.failure', compact('order'));
    }

    /**
     * Webhook Stripe pour les événements de paiement
     */
    public function webhook(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = config('services.stripe.webhook.secret');

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $sigHeader,
                $endpointSecret
            );
        } catch (\UnexpectedValueException $e) {
            Log::error('Webhook Stripe: Invalid payload', ['error' => $e->getMessage()]);
            return response('Invalid payload', 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            Log::error('Webhook Stripe: Invalid signature', ['error' => $e->getMessage()]);
            return response('Invalid signature', 400);
        }

        // Traiter les événements
        switch ($event->type) {
            case 'payment_intent.succeeded':
                $this->handlePaymentSucceeded($event->data->object);
                break;
            case 'payment_intent.payment_failed':
                $this->handlePaymentFailed($event->data->object);
                break;
            default:
                Log::info('Webhook Stripe: Event non géré', ['type' => $event->type]);
        }

        return response('Webhook handled', 200);
    }

    /**
     * Gérer un paiement réussi
     */
    private function handlePaymentSucceeded($paymentIntent)
    {
        $orderId = $paymentIntent->metadata->order_id ?? null;
        
        if ($orderId) {
            $order = Order::find($orderId);
            if ($order) {
                $order->update([
                    'status' => 'paid',
                    'payment_intent_id' => $paymentIntent->id,
                    'paid_at' => now(),
                ]);

                Log::info('Paiement confirmé via webhook', [
                    'order_id' => $orderId,
                    'payment_intent_id' => $paymentIntent->id,
                ]);
            }
        }
    }

    /**
     * Gérer un paiement échoué
     */
    private function handlePaymentFailed($paymentIntent)
    {
        $orderId = $paymentIntent->metadata->order_id ?? null;
        
        if ($orderId) {
            $order = Order::find($orderId);
            if ($order) {
                $order->update([
                    'status' => 'payment_failed',
                ]);

                Log::info('Paiement échoué via webhook', [
                    'order_id' => $orderId,
                    'payment_intent_id' => $paymentIntent->id,
                ]);
            }
        }
    }
}
