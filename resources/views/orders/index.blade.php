<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            📋 Mes commandes
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Messages de succès -->
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

            @if($orders->count() > 0)
                <div class="grid gap-6">
                    @foreach($orders as $order)
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-lg">
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-purple-400 rounded-lg flex items-center justify-center">
                                            <span class="text-white text-lg">📦</span>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                                Commande #{{ $order->id }}
                                            </h3>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                                {{ $order->created_at->format('d/m/Y à H:i') }}
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <div class="text-right">
                                        <div class="text-2xl font-bold text-green-600 dark:text-green-400">
                                            {{ number_format($order->total, 2) }}€
                                        </div>
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
                                </div>
                                
                                <!-- Produits de la commande -->
                                <div class="mb-4">
                                    <h4 class="font-medium text-gray-900 dark:text-gray-100 mb-2">
                                        Produits commandés :
                                    </h4>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($order->orderItems as $item)
                                            <span class="px-3 py-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-full text-sm">
                                                {{ $item->quantity }}x {{ $item->product->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                                
                                <!-- Adresse -->
                                <div class="mb-4">
                                    <h4 class="font-medium text-gray-900 dark:text-gray-100 mb-1">
                                        📍 Adresse de livraison :
                                    </h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ $order->address }}
                                    </p>
                                </div>

                                <!-- Informations de paiement si payée -->
                                @if($order->payment_method)
                                <div class="mb-4">
                                    <h4 class="font-medium text-gray-900 dark:text-gray-100 mb-1">
                                        💳 Paiement :
                                    </h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ $order->payment_method }} - {{ $order->payment_reference }}
                                        @if($order->paid_at)
                                            <br><span class="text-xs">Payé le {{ $order->paid_at->format('d/m/Y à H:i') }}</span>
                                        @endif
                                    </p>
                                </div>
                                @endif
                                
                                <!-- Actions -->
                                <div class="flex justify-between items-center pt-4 border-t border-gray-200 dark:border-gray-700">
                                    <a href="{{ route('orders.show', $order) }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition text-sm">
                                        👁️ Voir les détails
                                    </a>
                                    
                                    <div class="flex items-center space-x-4">
                                        @if($order->status === 'pending')
                                            <a href="{{ route('payments.show', $order) }}" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition text-sm">
                                                💳 Payer
                                            </a>
                                        @endif
                                        
                                        <div class="text-sm text-gray-500">
                                            {{ $order->orderItems->count() }} produit(s)
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="mt-6">
                    {{ $orders->links() }}
                </div>
            @else
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-lg">
                    <div class="p-12 text-center">
                        <div class="w-24 h-24 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-3xl">📦</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">
                            Aucune commande trouvée
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-6">
                            Vous n'avez pas encore passé de commande. Commencez par ajouter des produits à votre panier !
                        </p>
                        <a href="{{ route('products.index') }}" class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition font-semibold">
                            🛒 Voir les produits
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout> 