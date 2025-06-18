<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            📦 Commande #{{ $order->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Informations de la commande -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                            Informations de la commande
                        </h3>
                        <span class="px-3 py-1 text-sm font-medium rounded-full 
                            @if($order->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                            @elseif($order->status === 'paid') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                            @elseif($order->status === 'completed') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                            @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200 @endif">
                            @if($order->status === 'pending') ⏳ En attente
                            @elseif($order->status === 'paid') ✅ Payée
                            @elseif($order->status === 'completed') 🚚 Terminée
                            @else {{ ucfirst($order->status) }} @endif
                        </span>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="font-medium text-gray-900 dark:text-gray-100 mb-2">📅 Date de commande</h4>
                            <p class="text-gray-600 dark:text-gray-400">
                                {{ $order->created_at->format('d/m/Y à H:i') }}
                            </p>
                        </div>
                        
                        <div>
                            <h4 class="font-medium text-gray-900 dark:text-gray-100 mb-2">💰 Total</h4>
                            <p class="text-2xl font-bold text-green-600 dark:text-green-400">
                                {{ number_format($order->total, 2) }}€
                            </p>
                        </div>
                        
                        @if($order->payment_method)
                        <div>
                            <h4 class="font-medium text-gray-900 dark:text-gray-100 mb-2">💳 Méthode de paiement</h4>
                            <p class="text-gray-600 dark:text-gray-400">
                                {{ $order->payment_method }}
                            </p>
                        </div>
                        
                        <div>
                            <h4 class="font-medium text-gray-900 dark:text-gray-100 mb-2">🔢 Référence de paiement</h4>
                            <p class="text-gray-600 dark:text-gray-400">
                                {{ $order->payment_reference }}
                            </p>
                        </div>
                        
                        @if($order->paid_at)
                        <div>
                            <h4 class="font-medium text-gray-900 dark:text-gray-100 mb-2">✅ Date de paiement</h4>
                            <p class="text-gray-600 dark:text-gray-400">
                                {{ $order->paid_at->format('d/m/Y à H:i') }}
                            </p>
                        </div>
                        @endif
                        @endif
                        
                        <div class="md:col-span-2">
                            <h4 class="font-medium text-gray-900 dark:text-gray-100 mb-2">📍 Adresse de livraison</h4>
                            <p class="text-gray-600 dark:text-gray-400">
                                {{ $order->address }}
                            </p>
                        </div>
                    </div>

                    <!-- Bouton de paiement pour les commandes en attente -->
                    @if($order->status === 'pending')
                        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <div class="flex justify-center">
                                <a href="{{ route('payments.show', $order) }}" class="bg-green-500 text-white px-8 py-3 rounded-lg hover:bg-green-600 transition font-semibold text-lg">
                                    💳 Procéder au paiement
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Produits commandés -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                        🛍️ Produits commandés
                    </h3>
                    
                    <div class="space-y-4">
                        @foreach($order->orderItems as $item)
                            <div class="flex items-center justify-between p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-gradient-to-br from-purple-400 to-pink-400 rounded-lg flex items-center justify-center">
                                        <span class="text-white text-sm">🛍️</span>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900 dark:text-gray-100">
                                            {{ $item->product->name }}
                                        </h4>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            {{ $item->product->category->name }}
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            Prix unitaire : {{ number_format($item->price, 2) }}€
                                        </p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="font-semibold text-gray-900 dark:text-gray-100">
                                        {{ $item->quantity }}x
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        = {{ number_format($item->price * $item->quantity, 2) }}€
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Total -->
                    <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex justify-between items-center text-lg font-bold text-gray-900 dark:text-gray-100">
                            <span>Total :</span>
                            <span>{{ number_format($order->total, 2) }}€</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="mt-6 flex justify-between">
                <a href="{{ route('orders.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition">
                    ← Retour aux commandes
                </a>
                
                <a href="{{ route('products.index') }}" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition">
                    🛒 Continuer les achats
                </a>
            </div>
        </div>
    </div>
</x-app-layout> 