<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            💳 Finaliser le paiement - Commande #{{ $order->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Messages de succès et d'erreur -->
            @if(session('success'))
                <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4 mb-6">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700 dark:text-green-300">
                                {{ session('success') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4 mb-6">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700 dark:text-red-300">
                                {{ session('error') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4 mb-6">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700 dark:text-red-300 font-medium">
                                Veuillez corriger les erreurs suivantes :
                            </p>
                            <ul class="mt-2 text-sm text-red-700 dark:text-red-300 list-disc list-inside">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Formulaire de paiement -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                            💳 Informations de paiement
                        </h3>
                        
                        <form action="{{ route('payments.process', $order) }}" method="POST" id="payment-form">
                            @csrf
                            
                            <div class="space-y-4">
                                <div>
                                    <label for="cardholder_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Nom du titulaire *
                                    </label>
                                    <input 
                                        type="text" 
                                        name="cardholder_name" 
                                        id="cardholder_name" 
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                        placeholder="Jean Dupont"
                                        value="{{ old('cardholder_name') }}"
                                        required
                                    >
                                    @error('cardholder_name')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="card_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Numéro de carte *
                                    </label>
                                    <div class="relative">
                                        <input 
                                            type="text" 
                                            name="card_number" 
                                            id="card_number" 
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 pr-10 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                            placeholder="1234 5678 9012 3456"
                                            value="{{ old('card_number') }}"
                                            maxlength="19"
                                            required
                                        >
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                            <span class="text-gray-400">💳</span>
                                        </div>
                                    </div>
                                    @error('card_number')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="grid grid-cols-3 gap-4">
                                    <div>
                                        <label for="expiry_month" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                            Mois *
                                        </label>
                                        <select 
                                            name="expiry_month" 
                                            id="expiry_month" 
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                            required
                                        >
                                            <option value="">MM</option>
                                            @for($i = 1; $i <= 12; $i++)
                                                <option value="{{ $i }}" {{ old('expiry_month') == $i ? 'selected' : '' }}>
                                                    {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}
                                                </option>
                                            @endfor
                                        </select>
                                        @error('expiry_month')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="expiry_year" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                            Année *
                                        </label>
                                        <select 
                                            name="expiry_year" 
                                            id="expiry_year" 
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                            required
                                        >
                                            <option value="">YYYY</option>
                                            @for($i = date('Y'); $i <= date('Y') + 10; $i++)
                                                <option value="{{ $i }}" {{ old('expiry_year') == $i ? 'selected' : '' }}>
                                                    {{ $i }}
                                                </option>
                                            @endfor
                                        </select>
                                        @error('expiry_year')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="cvv" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                            CVV *
                                        </label>
                                        <input 
                                            type="text" 
                                            name="cvv" 
                                            id="cvv" 
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                            placeholder="123"
                                            value="{{ old('cvv') }}"
                                            maxlength="3"
                                            required
                                        >
                                        @error('cvv')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Cartes de test -->
                                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm text-blue-700 dark:text-blue-300">
                                                <strong>Cartes de test :</strong><br>
                                                Visa: 4242 4242 4242 4242<br>
                                                Mastercard: 5555 5555 5555 4444<br>
                                                CVV: 123 | Date: n'importe quelle date future
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Bouton de paiement -->
                                <button type="submit" class="w-full bg-green-500 text-white py-3 px-6 rounded-lg hover:bg-green-600 transition font-semibold text-lg" id="pay-button">
                                    ✅ Finaliser la commande - {{ number_format($order->total, 2) }}€
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Récapitulatif de la commande -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                            📋 Récapitulatif de votre commande
                        </h3>
                        
                        <div class="space-y-4">
                            @foreach($order->orderItems as $item)
                                <div class="flex items-center justify-between p-3 border border-gray-200 dark:border-gray-700 rounded-lg">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-gradient-to-br from-purple-400 to-pink-400 rounded-lg flex items-center justify-center">
                                            <span class="text-white text-sm">🛍️</span>
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-gray-900 dark:text-gray-100 text-sm">
                                                {{ $item->product->name }}
                                            </h4>
                                            <p class="text-xs text-gray-600 dark:text-gray-400">
                                                {{ $item->quantity }}x {{ number_format($item->price, 2) }}€
                                            </p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="font-semibold text-gray-900 dark:text-gray-100 text-sm">
                                            {{ number_format($item->price * $item->quantity, 2) }}€
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- Total -->
                        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <div class="flex justify-between items-center text-lg font-bold text-gray-900 dark:text-gray-100">
                                <span>Total à payer :</span>
                                <span class="text-2xl text-green-600 dark:text-green-400">{{ number_format($order->total, 2) }}€</span>
                            </div>
                        </div>

                        <!-- Adresse de livraison -->
                        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <h4 class="font-semibold text-gray-900 dark:text-gray-100 mb-2">📍 Adresse de livraison</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $order->address }}</p>
                        </div>
                        
                        <!-- Informations de sécurité -->
                        <div class="mt-6 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-green-700 dark:text-green-300">
                                        <strong>Paiement sécurisé :</strong> Vos informations sont protégées par un chiffrement SSL.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Formatage automatique du numéro de carte
        document.getElementById('card_number').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\s/g, '').replace(/\D/g, '');
            value = value.replace(/(\d{4})(?=\d)/g, '$1 ');
            e.target.value = value.substring(0, 19);
        });

        // Désactiver le bouton pendant le traitement et nettoyer les espaces
        document.getElementById('payment-form').addEventListener('submit', function(e) {
            // Nettoyer les espaces du numéro de carte avant soumission
            const cardNumberInput = document.getElementById('card_number');
            cardNumberInput.value = cardNumberInput.value.replace(/\s/g, '');
            
            const button = document.getElementById('pay-button');
            button.disabled = true;
            button.textContent = '⏳ Traitement en cours...';
        });
    </script>
</x-app-layout> 