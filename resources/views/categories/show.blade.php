<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $category->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <nav class="mb-6">
                <ol class="flex items-center space-x-2 text-sm text-gray-500">
                    <li><a href="{{ route('products.index') }}" class="hover:text-blue-600">Produits</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li class="text-gray-900">{{ $category->name }}</li>
                </ol>
            </nav>

            <!-- En-tête de la catégorie -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-lg mb-8">
                <div class="p-8">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                                {{ $category->name }}
                            </h1>
                            <p class="text-gray-600 dark:text-gray-400 text-lg">
                                {{ $category->description }}
                            </p>
                            <p class="text-sm text-gray-500 mt-2">
                                {{ $products->total() }} produit(s) dans cette catégorie
                            </p>
                        </div>
                        <div class="text-6xl">
                            @switch($category->name)
                                @case('Énergisants')
                                    ⚡
                                    @break
                                @case('Relaxants')
                                    😌
                                    @break
                                @case('Stimulants')
                                    💪
                                    @break
                                @case('Confort')
                                    🪑
                                    @break
                                @case('Accessoires')
                                    🎮
                                    @break
                                @default
                                    🛍️
                            @endswitch
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navigation des catégories -->
            <div class="mb-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-3">Toutes les catégories :</h3>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('products.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                        Tous
                    </a>
                    @foreach(\App\Models\Category::all() as $cat)
                        <a href="{{ route('categories.show', $cat) }}" 
                           class="px-4 py-2 rounded-lg transition {{ $cat->id === $category->id ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                            {{ $cat->name }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Grille des produits -->
            @if($products->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($products as $product)
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-lg hover:shadow-xl transition-shadow duration-300">
                            <!-- Image du produit -->
                            <div class="h-48 bg-gradient-to-br from-purple-400 to-pink-400 flex items-center justify-center">
                                <span class="text-white text-2xl">🛍️</span>
                            </div>
                            
                            <div class="p-6">
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
                                    <button class="bg-green-500 text-white py-2 px-4 rounded-lg hover:bg-green-600 transition">
                                        🛒
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $products->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <div class="text-6xl mb-4">😔</div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">
                        Aucun produit trouvé
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">
                        Il n'y a pas encore de produits dans cette catégorie.
                    </p>
                    <a href="{{ route('products.index') }}" 
                       class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition">
                        Voir tous les produits
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout> 