<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            🛒 Mon Panier
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(count($products) > 0)
                <!-- Liste des produits du panier -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                            Produits dans votre panier ({{ count($products) }})
                        </h3>
                        
                        <div class="space-y-4">
                            @foreach($products as $item)
                                <div class="flex items-center justify-between p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                                    <div class="flex items-center space-x-4">
                                        <!-- Image du produit -->
                                        <div class="w-16 h-16 bg-gradient-to-br from-purple-400 to-pink-400 rounded-lg flex items-center justify-center">
                                            <span class="text-white text-xl">🛍️</span>
                                        </div>
                                        
                                        <!-- Informations du produit -->
                                        <div>
                                            <h4 class="font-semibold text-gray-900 dark:text-gray-100">
                                                {{ $item['product']->name }}
                                            </h4>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                                {{ $item['product']->category->name }}
                                            </p>
                                            <p class="text-sm text-gray-500">
                                                Stock disponible: {{ $item['product']->stock }}
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <!-- Quantité et prix -->
                                    <div class="flex items-center space-x-4">
                                        <div class="flex items-center space-x-2">
                                            <label class="text-sm text-gray-600 dark:text-gray-400">Qté:</label>
                                            <form action="{{ route('cart.update', $item['product']) }}" method="POST" class="flex items-center space-x-2">
                                                @csrf
                                                @method('PUT')
                                                <select name="quantity" onchange="this.form.submit()" class="border border-gray-300 rounded px-2 py-1 text-sm">
                                                    @for($i = 1; $i <= min(10, $item['product']->stock); $i++)
                                                        <option value="{{ $i }}" {{ $item['quantity'] == $i ? 'selected' : '' }}>
                                                            {{ $i }}
                                                        </option>
                                                    @endfor
                                                </select>
                                            </form>
                                        </div>
                                        
                                        <div class="text-right">
                                            <div class="font-semibold text-green-600">
                                                {{ number_format($item['subtotal'], 2) }}€
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ number_format($item['product']->price, 2) }}€ l'unité
                                            </div>
                                        </div>
                                        
                                        <!-- Bouton supprimer -->
                                        <form action="{{ route('cart.remove', $item['product']) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 transition">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- Total et actions -->
                        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <div class="flex justify-between items-center">
                                <div class="text-xl font-bold text-gray-900 dark:text-gray-100">
                                    Total: {{ number_format($total, 2) }}€
                                </div>
                                
                                <div class="flex space-x-4">
                                    <form action="{{ route('cart.clear') }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">
                                            Vider le panier
                                        </button>
                                    </form>
                                    
                                    <a href="{{ route('products.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                                        Continuer les achats
                                    </a>
                                    
                                    <a href="{{ route('orders.checkout') }}" class="bg-green-500 text-white px-6 py-2 rounded-lg hover:bg-green-600 transition font-semibold">
                                        Commander
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- Panier vide -->
                <div class="text-center py-12">
                    <div class="text-6xl mb-4">🛒</div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">
                        Votre panier est vide
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">
                        Ajoutez quelques produits pour commencer vos achats !
                    </p>
                    <a href="{{ route('products.index') }}" 
                       class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition">
                        Découvrir nos produits
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout> 