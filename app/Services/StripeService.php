<?php

namespace App\Services;

use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Exception\ApiErrorException;
use App\Models\Order;

class StripeService
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    /**
     * Créer un PaymentIntent pour une commande
     */
    public function createPaymentIntent(Order $order): array
    {
        try {
            $paymentIntent = PaymentIntent::create([
                'amount' => (int) ($order->total_amount * 100), // Stripe utilise les centimes
                'currency' => 'eur',
                'metadata' => [
                    'order_id' => $order->id,
                    'user_id' => $order->user_id,
                ],
                'automatic_payment_methods' => [
                    'enabled' => true,
                ],
            ]);

            return [
                'success' => true,
                'client_secret' => $paymentIntent->client_secret,
                'payment_intent_id' => $paymentIntent->id,
            ];
        } catch (ApiErrorException $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Récupérer un PaymentIntent
     */
    public function retrievePaymentIntent(string $paymentIntentId): ?PaymentIntent
    {
        try {
            return PaymentIntent::retrieve($paymentIntentId);
        } catch (ApiErrorException $e) {
            return null;
        }
    }

    /**
     * Confirmer un PaymentIntent
     */
    public function confirmPaymentIntent(string $paymentIntentId): array
    {
        try {
            $paymentIntent = PaymentIntent::retrieve($paymentIntentId);
            
            if ($paymentIntent->status === 'succeeded') {
                return [
                    'success' => true,
                    'status' => 'succeeded',
                    'payment_intent' => $paymentIntent,
                ];
            }

            return [
                'success' => false,
                'error' => 'Le paiement n\'a pas été confirmé',
                'status' => $paymentIntent->status,
            ];
        } catch (ApiErrorException $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Annuler un PaymentIntent
     */
    public function cancelPaymentIntent(string $paymentIntentId): array
    {
        try {
            $paymentIntent = PaymentIntent::retrieve($paymentIntentId);
            $paymentIntent->cancel();

            return [
                'success' => true,
                'status' => 'cancelled',
            ];
        } catch (ApiErrorException $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
} 