<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="text-center">
                        <!-- Icône de succès -->
                        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 mb-4">
                            <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>

                        <h1 class="text-2xl font-bold text-gray-900 mb-2">Paiement réussi !</h1>
                        <p class="text-gray-600 mb-6">Votre commande #{{ $order->id }} a été payée avec succès.</p>

                        <!-- Détails de la commande -->
                        <div class="bg-gray-50 rounded-lg p-6 mb-6 max-w-md mx-auto">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Récapitulatif de votre commande</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Numéro de commande:</span>
                                    <span class="font-medium">#{{ $order->id }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Montant total:</span>
                                    <span class="font-bold text-lg">{{ number_format($order->total_amount, 2) }} €</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Date de paiement:</span>
                                    <span class="font-medium">{{ $order->paid_at->format('d/m/Y H:i') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Articles commandés -->
                        <div class="bg-white border border-gray-200 rounded-lg p-6 mb-6 max-w-md mx-auto">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Articles commandés</h3>
                            <div class="space-y-3">
                                @foreach($order->items as $item)
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <span class="font-medium">{{ $item->product->name }}</span>
                                            <span class="text-gray-500 text-sm">x{{ $item->quantity }}</span>
                                        </div>
                                        <span class="font-medium">{{ number_format($item->price * $item->quantity, 2) }} €</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="{{ route('orders.show', $order) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-md transition">
                                Voir les détails de la commande
                            </a>
                            <a href="{{ route('orders.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded-md transition">
                                Mes commandes
                            </a>
                            <a href="{{ route('products.index') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-md transition">
                                Continuer mes achats
                            </a>
                        </div>

                        <!-- Informations supplémentaires -->
                        <div class="mt-8 text-sm text-gray-500">
                            <p>Un email de confirmation vous a été envoyé à <strong>{{ auth()->user()->email }}</strong></p>
                            <p class="mt-2">Vous recevrez un email de suivi dès que votre commande sera expédiée.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 