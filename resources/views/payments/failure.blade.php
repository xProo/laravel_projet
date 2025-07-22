<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="text-center">
                        <!-- Icône d'erreur -->
                        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                            <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>

                        <h1 class="text-2xl font-bold text-gray-900 mb-2">Paiement échoué</h1>
                        <p class="text-gray-600 mb-6">Le paiement de votre commande #{{ $order->id }} n'a pas pu être traité.</p>

                        @if(session('error'))
                            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6 max-w-md mx-auto">
                                <p class="text-red-700">{{ session('error') }}</p>
                            </div>
                        @endif

                        <!-- Détails de la commande -->
                        <div class="bg-gray-50 rounded-lg p-6 mb-6 max-w-md mx-auto">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Détails de la commande</h3>
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
                                    <span class="text-gray-600">Statut:</span>
                                    <span class="font-medium text-red-600">{{ ucfirst($order->status) }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="{{ route('payments.show', $order) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-md transition">
                                Réessayer le paiement
                            </a>
                            <a href="{{ route('orders.show', $order) }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded-md transition">
                                Voir les détails de la commande
                            </a>
                            <a href="{{ route('orders.index') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-md transition">
                                Mes commandes
                            </a>
                        </div>

                        <!-- Conseils -->
                        <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-4 max-w-md mx-auto">
                            <h4 class="font-medium text-blue-900 mb-2">Conseils pour résoudre le problème :</h4>
                            <ul class="text-sm text-blue-700 space-y-1 text-left">
                                <li>• Vérifiez que votre carte bancaire est valide</li>
                                <li>• Assurez-vous d'avoir suffisamment de fonds</li>
                                <li>• Vérifiez les informations de votre carte</li>
                                <li>• Essayez avec une autre carte si possible</li>
                                <li>• Contactez votre banque si le problème persiste</li>
                            </ul>
                        </div>

                        <!-- Support -->
                        <div class="mt-6 text-sm text-gray-500">
                            <p>Si le problème persiste, contactez notre support client.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 