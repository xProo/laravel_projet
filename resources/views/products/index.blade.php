<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            🛒 Notre Collection de "Produits Illicites" (100% Fictifs)
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Message d'avertissement humoristique -->
            <div class="mb-6 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm">
                            <strong>ATTENTION :</strong> Ce site est 100% fictif et humoristique. Tous les produits sont imaginaires et créés pour le plaisir. Aucune vente réelle n'est effectuée.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Navigation des catégories -->
            <div class="mb-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-3">Catégories :</h3>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('products.index') }}" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                        Tous
                    </a>
                    @foreach(\App\Models\Category::all() as $category)
                        <a href="{{ route('categories.show', $category) }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Barre de recherche avec recherche vocale -->
            <div class="mb-6 search-container relative">
                <div class="flex items-center gap-4">
                    <div class="flex-1 relative">
                        <input type="text" 
                               id="search-input" 
                               placeholder="Rechercher un produit..." 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <!-- Le bouton de recherche vocale sera ajouté ici par JavaScript -->
                </div>
                <!-- Les résultats de recherche vocale apparaîtront ici -->
            </div>

            <!-- Grille des produits -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($products as $product)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-lg hover:shadow-xl transition-shadow duration-300">
                        <!-- Image du produit (placeholder pour l'instant) -->
                        <div class="h-48 bg-gradient-to-br from-purple-400 to-pink-400 flex items-center justify-center">
                            <span class="text-white text-2xl">🛍️</span>
                        </div>
                        
                        <div class="p-6">
                            <!-- Catégorie -->
                            <div class="mb-2">
                                <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">
                                    {{ $product->category->name }}
                                </span>
                            </div>
                            
                            <!-- Nom du produit -->
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">
                                {{ $product->name }}
                            </h3>
                            
                            <!-- Description -->
                            <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 line-clamp-2">
                                {{ $product->description }}
                            </p>
                            
                            <!-- Prix et stock -->
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-2xl font-bold text-green-600">
                                    {{ number_format($product->price, 2) }}€
                                </span>
                                <span class="text-sm text-gray-500">
                                    Stock: {{ $product->stock }}
                                </span>
                            </div>
                            
                            <!-- Boutons d'action -->
                            <div class="flex gap-2">
                                <a href="{{ route('products.show', $product) }}" 
                                   class="flex-1 bg-blue-500 text-white text-center py-2 px-4 rounded-lg hover:bg-blue-600 transition">
                                    Voir détails
                                </a>
                                @if($product->stock > 0)
                                    <form action="{{ route('cart.add', $product) }}" method="POST" class="inline">
                                        @csrf
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="bg-green-500 text-white py-2 px-4 rounded-lg hover:bg-green-600 transition">
                                            🛒
                                        </button>
                                    </form>
                                @else
                                    <button disabled class="bg-gray-400 text-white py-2 px-4 rounded-lg cursor-not-allowed">
                                        ❌
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $products->links() }}
            </div>
        </div>
    </div>

    <!-- Script de recherche vocale -->
    <script src="{{ asset('js/voice-search.js') }}"></script>
</x-app-layout> 