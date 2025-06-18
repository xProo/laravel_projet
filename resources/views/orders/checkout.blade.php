<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            🛒 Finaliser la commande
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('orders.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Formulaire d'adresse -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                                📍 Informations de livraison
                            </h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Adresse complète *
                                    </label>
                                    <textarea 
                                        name="address" 
                                        id="address" 
                                        rows="3" 
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                        placeholder="123 Rue de la Paix, Appartement 4B"
                                        required
                                    >{{ old('address') }}</textarea>
                                    @error('address')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                            Ville *
                                        </label>
                                        <input 
                                            type="text" 
                                            name="city" 
                                            id="city" 
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                            placeholder="Paris"
                                            value="{{ old('city') }}"
                                            required
                                        >
                                        @error('city')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="postal_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                            Code postal *
                                        </label>
                                        <input 
                                            type="text" 
                                            name="postal_code" 
                                            id="postal_code" 
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                            placeholder="75001"
                                            value="{{ old('postal_code') }}"
                                            required
                                        >
                                        @error('postal_code')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Téléphone *
                                    </label>
                                    <input 
                                        type="tel" 
                                        name="phone" 
                                        id="phone" 
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                        placeholder="06 12 34 56 78"
                                        value="{{ old('phone') }}"
                                        required
                                    >
                                    @error('phone')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm text-blue-700 dark:text-blue-300">
                                                <strong>Note :</strong> Ce site est fictif. Aucune livraison réelle ne sera effectuée.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Récapitulatif de la commande -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                                📋 Récapitulatif de votre commande
                            </h3>
                            
                            <div class="space-y-4">
                                @foreach($products as $item)
                                    <div class="flex items-center justify-between p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                                        <div class="flex items-center space-x-4">
                                            <div class="w-12 h-12 bg-gradient-to-br from-purple-400 to-pink-400 rounded-lg flex items-center justify-center">
                                                <span class="text-white text-sm">🛍️</span>
                                            </div>
                                            <div>
                                                <h4 class="font-semibold text-gray-900 dark:text-gray-100">
                                                    {{ $item['product']->name }}
                                                </h4>
                                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                                    {{ $item['product']->category->name }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="font-semibold text-gray-900 dark:text-gray-100">
                                                {{ $item['quantity'] }}x {{ number_format($item['product']->price, 2) }}€
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                = {{ number_format($item['subtotal'], 2) }}€
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            <!-- Total -->
                            <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                                <div class="flex justify-between items-center text-lg font-bold text-gray-900 dark:text-gray-100">
                                    <span>Total :</span>
                                    <span>{{ number_format($total, 2) }}€</span>
                                </div>
                            </div>
                            
                            <!-- Bouton de confirmation -->
                            <div class="mt-6">
                                <button type="submit" class="w-full bg-green-500 text-white py-3 px-6 rounded-lg hover:bg-green-600 transition font-semibold text-lg">
                                    ✅ Confirmer la commande et procéder au paiement
                                </button>
                            </div>
                            
                            <div class="mt-4 text-center">
                                <a href="{{ route('cart.index') }}" class="text-blue-500 hover:text-blue-600 text-sm">
                                    ← Retour au panier
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout> 