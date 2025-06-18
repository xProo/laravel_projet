<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Afficher le formulaire de paiement
     */
    public function show(Order $order)
    {
        // Vérifier que l'utilisateur peut payer cette commande
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        if ($order->status !== 'pending') {
            return redirect()->route('orders.show', $order)->with('error', 'Cette commande ne peut plus être payée.');
        }

        return view('payments.show', compact('order'));
    }

    /**
     * Traiter le paiement
     */
    public function process(Request $request, Order $order)
    {
        // Vérifier que l'utilisateur peut payer cette commande
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        if ($order->status !== 'pending') {
            return redirect()->route('orders.show', $order)->with('error', 'Cette commande ne peut plus être payée.');
        }

        // Nettoyer le numéro de carte des espaces
        $cardNumber = str_replace(' ', '', $request->card_number);

        $request->validate([
            'card_number' => 'required|string|min:16|max:19', // Accepter avec ou sans espaces
            'expiry_month' => 'required|integer|between:1,12',
            'expiry_year' => 'required|integer|min:' . date('Y'),
            'cvv' => 'required|string|size:3',
            'cardholder_name' => 'required|string|min:3',
        ]);

        // Vérifier que le numéro de carte fait exactement 16 chiffres après nettoyage
        if (!preg_match('/^\d{16}$/', $cardNumber)) {
            return back()->withErrors(['card_number' => 'Le numéro de carte doit contenir exactement 16 chiffres.'])->withInput();
        }

        // Simulation de traitement de paiement
        try {
            DB::beginTransaction();

            // Simuler un délai de traitement
            sleep(1);

            // Simuler une validation de carte (pour la démo, on accepte tout)
            $lastFour = substr($cardNumber, -4);
            
            // Simuler différents types de cartes
            $cardType = $this->getCardType($cardNumber);
            
            // Simuler un succès de paiement (90% de chance)
            $paymentSuccess = rand(1, 10) <= 9; // 90% de succès

            if ($paymentSuccess) {
                // Mettre à jour le statut de la commande
                $order->update([
                    'status' => 'paid',
                    'payment_method' => $cardType,
                    'payment_reference' => 'PAY-' . strtoupper(uniqid()),
                    'paid_at' => now(),
                ]);

                DB::commit();

                // Rediriger vers l'historique des commandes avec un message de succès
                return redirect()->route('orders.index')
                    ->with('success', '🎉 Paiement traité avec succès ! Votre commande #' . $order->id . ' a été confirmée et sera livrée bientôt.');

            } else {
                // Simuler un échec de paiement
                DB::rollBack();
                
                return back()->with('error', '❌ Paiement refusé. Veuillez vérifier vos informations de carte ou essayer une autre carte.');
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur lors du traitement du paiement. Veuillez réessayer.');
        }
    }

    /**
     * Page de succès de paiement (plus utilisée, redirection directe vers l'historique)
     */
    public function success(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        return redirect()->route('orders.index')->with('success', 'Paiement traité avec succès !');
    }

    /**
     * Page d'échec de paiement
     */
    public function failure(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        return view('payments.failure', compact('order'));
    }

    /**
     * Déterminer le type de carte basé sur le numéro
     */
    private function getCardType($cardNumber)
    {
        $firstDigit = substr($cardNumber, 0, 1);
        $firstTwoDigits = substr($cardNumber, 0, 2);
        $firstFourDigits = substr($cardNumber, 0, 4);

        if ($firstDigit === '4') {
            return 'Visa';
        } elseif (in_array($firstTwoDigits, ['51', '52', '53', '54', '55'])) {
            return 'Mastercard';
        } elseif (in_array($firstFourDigits, ['6011', '644', '645', '646', '647', '648', '649', '65'])) {
            return 'Discover';
        } elseif (in_array($firstTwoDigits, ['34', '37'])) {
            return 'American Express';
        } else {
            return 'Carte bancaire';
        }
    }
}
