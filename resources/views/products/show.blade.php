<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $product->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <nav class="mb-6">
                <ol class="flex items-center space-x-2 text-sm text-gray-500">
                    <li><a href="{{ route('products.index') }}" class="hover:text-blue-600">Produits</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li><a href="{{ route('categories.show', $product->category) }}" class="hover:text-blue-600">{{ $product->category->name }}</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li class="text-gray-900">{{ $product->name }}</li>
                </ol>
            </nav>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-lg">
                <div class="md:flex">
                    <!-- Image du produit -->
                    <div class="md:w-1/2">
                        <div class="h-96 bg-gradient-to-br from-purple-400 to-pink-400 flex items-center justify-center">
                            <span class="text-white text-6xl">🛍️</span>
                        </div>
                    </div>
                    
                    <!-- Informations du produit -->
                    <div class="md:w-1/2 p-8">
                        <!-- Catégorie -->
                        <div class="mb-4">
                            <span class="inline-block bg-blue-100 text-blue-800 text-sm px-3 py-1 rounded-full">
                                {{ $product->category->name }}
                            </span>
                        </div>
                        
                        <!-- Nom du produit -->
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-4">
                            {{ $product->name }}
                        </h1>
                        
                        <!-- Prix -->
                        <div class="mb-6">
                            <span class="text-4xl font-bold text-green-600">
                                {{ number_format($product->price, 2) }}€
                            </span>
                        </div>
                        
                        <!-- Description -->
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Description :</h3>
                            <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                                {{ $product->description }}
                            </p>
                        </div>
                        
                        <!-- Stock -->
                        <div class="mb-6">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Stock disponible :</span>
                                <span class="font-semibold {{ $product->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $product->stock > 0 ? $product->stock . ' unités' : 'Rupture de stock' }}
                                </span>
                            </div>
                        </div>
                        
                        <!-- Actions -->
                        <div class="space-y-4">
                            @if($product->stock > 0)
                                <form action="{{ route('cart.add', $product) }}" method="POST">
                                    @csrf
                                    <div class="flex items-center space-x-4 mb-4">
                                        <label for="quantity" class="text-gray-700 dark:text-gray-300">Quantité :</label>
                                        <select name="quantity" id="quantity" class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            @for($i = 1; $i <= min(10, $product->stock); $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    
                                    <div class="flex space-x-4">
                                        <button type="submit" class="flex-1 bg-green-500 text-white py-3 px-6 rounded-lg hover:bg-green-600 transition font-semibold">
                                            🛒 Ajouter au panier
                                        </button>
                                        <button type="button" class="bg-blue-500 text-white py-3 px-6 rounded-lg hover:bg-blue-600 transition">
                                            ❤️ Favoris
                                        </button>
                                    </div>
                                </form>
                            @else
                                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                                    <strong>Rupture de stock !</strong> Ce produit n'est plus disponible pour le moment.
                                </div>
                            @endif
                        </div>
                        
                        <!-- Informations supplémentaires -->
                        <div class="mt-8 pt-6 border-t border-gray-200">
                            <div class="grid grid-cols-2 gap-4 text-sm text-gray-600 dark:text-gray-400">
                                <div>
                                    <span class="font-semibold">Référence :</span> PROD-{{ $product->id }}
                                </div>
                                <div>
                                    <span class="font-semibold">Ajouté le :</span> {{ $product->created_at->format('d/m/Y') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Produits similaires -->
            <div class="mt-12">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6">Produits similaires</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($product->category->products()->where('id', '!=', $product->id)->limit(3)->get() as $similarProduct)
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-lg hover:shadow-xl transition-shadow duration-300">
                            <div class="h-32 bg-gradient-to-br from-blue-400 to-purple-400 flex items-center justify-center">
                                <span class="text-white text-2xl">🛍️</span>
                            </div>
                            <div class="p-4">
                                <h4 class="font-semibold text-gray-900 dark:text-gray-100 mb-2">{{ $similarProduct->name }}</h4>
                                <p class="text-gray-600 dark:text-gray-400 text-sm mb-3">{{ Str::limit($similarProduct->description, 60) }}</p>
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-bold text-green-600">{{ number_format($similarProduct->price, 2) }}€</span>
                                    <a href="{{ route('products.show', $similarProduct) }}" class="text-blue-500 hover:text-blue-600 text-sm">Voir →</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 