<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h1 class="text-2xl font-bold text-gray-900 mb-2">Paiement de la commande #{{ $order->id }}</h1>
                        <p class="text-gray-600">Montant total: <span class="font-bold text-lg">{{ number_format($order->total_amount, 2) }} €</span></p>
                    </div>

                    <!-- Résumé de la commande -->
                    <div class="bg-gray-50 rounded-lg p-4 mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-3">Résumé de votre commande</h3>
                        <div class="space-y-2">
                            @foreach($order->items as $item)
                                <div class="flex justify-between">
                                    <span>{{ $item->product->name }} x{{ $item->quantity }}</span>
                                    <span>{{ number_format($item->price * $item->quantity, 2) }} €</span>
                                </div>
                            @endforeach
                            <hr class="my-2">
                            <div class="flex justify-between font-bold">
                                <span>Total</span>
                                <span>{{ number_format($order->total_amount, 2) }} €</span>
                            </div>
                        </div>
                    </div>

                    <!-- Formulaire de paiement Stripe -->
                    <form id="payment-form" class="space-y-6">
                        <div>
                            <label for="card-element" class="block text-sm font-medium text-gray-700 mb-2">
                                Informations de carte bancaire
                            </label>
                            <div id="card-element" class="border border-gray-300 rounded-md p-3 focus-within:ring-2 focus-within:ring-indigo-500 focus-within:border-indigo-500">
                                <!-- Stripe Elements sera inséré ici -->
                            </div>
                            <div id="card-errors" class="mt-2 text-sm text-red-600" role="alert"></div>
                        </div>

                        <div class="flex items-center justify-between">
                            <a href="{{ route('orders.show', $order) }}" class="text-indigo-600 hover:text-indigo-800">
                                ← Retour à la commande
                            </a>
                            <button type="submit" id="submit-button" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed">
                                <span id="button-text">Payer {{ number_format($order->total_amount, 2) }} €</span>
                                <span id="spinner" class="hidden">
                                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Traitement...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Script Stripe -->
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        // Initialiser Stripe
        const stripe = Stripe('{{ $stripeKey }}');
        const elements = stripe.elements();

        // Créer l'élément de carte
        const cardElement = elements.create('card', {
            style: {
                base: {
                    fontSize: '16px',
                    color: '#424770',
                    '::placeholder': {
                        color: '#aab7c4',
                    },
                },
                invalid: {
                    color: '#9e2146',
                },
            },
        });

        // Monter l'élément de carte
        cardElement.mount('#card-element');

        // Gérer les erreurs de validation en temps réel
        cardElement.addEventListener('change', function(event) {
            const displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });

        // Gérer la soumission du formulaire
        const form = document.getElementById('payment-form');
        const submitButton = document.getElementById('submit-button');
        const buttonText = document.getElementById('button-text');
        const spinner = document.getElementById('spinner');

        form.addEventListener('submit', async function(event) {
            event.preventDefault();

            // Désactiver le bouton et afficher le spinner
            submitButton.disabled = true;
            buttonText.classList.add('hidden');
            spinner.classList.remove('hidden');

            // Confirmer le paiement
            const { error, paymentIntent } = await stripe.confirmCardPayment('{{ $clientSecret }}', {
                payment_method: {
                    card: cardElement,
                }
            });

            if (error) {
                // Afficher l'erreur
                const errorElement = document.getElementById('card-errors');
                errorElement.textContent = error.message;
                
                // Réactiver le bouton
                submitButton.disabled = false;
                buttonText.classList.remove('hidden');
                spinner.classList.add('hidden');
            } else {
                // Paiement réussi, envoyer au serveur
                const formData = new FormData();
                formData.append('payment_intent_id', paymentIntent.id);
                formData.append('_token', '{{ csrf_token() }}');

                try {
                    const response = await fetch('{{ route("payments.process", $order) }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                        }
                    });

                    if (response.ok) {
                        // Rediriger vers la page de succès
                        window.location.href = '{{ route("payments.success", $order) }}';
                    } else {
                        throw new Error('Erreur lors du traitement du paiement');
                    }
                } catch (error) {
                    const errorElement = document.getElementById('card-errors');
                    errorElement.textContent = 'Erreur lors du traitement du paiement. Veuillez réessayer.';
                    
                    // Réactiver le bouton
                    submitButton.disabled = false;
                    buttonText.classList.remove('hidden');
                    spinner.classList.add('hidden');
                }
            }
        });
    </script>
</x-app-layout> 