<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            📂 Catégories de Produits
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Grille des catégories -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($categories as $category)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-lg hover:shadow-xl transition-shadow duration-300">
                        <!-- Image de la catégorie -->
                        <div class="h-48 bg-gradient-to-br from-blue-400 to-purple-400 flex items-center justify-center">
                            <span class="text-white text-4xl">
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
                            </span>
                        </div>
                        
                        <div class="p-6">
                            <!-- Nom de la catégorie -->
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">
                                {{ $category->name }}
                            </h3>
                            
                            <!-- Description -->
                            <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">
                                {{ $category->description }}
                            </p>
                            
                            <!-- Nombre de produits -->
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-sm text-gray-500">
                                    {{ $category->products_count }} produit(s)
                                </span>
                            </div>
                            
                            <!-- Bouton d'action -->
                            <a href="{{ route('categories.show', $category) }}" 
                               class="block w-full bg-blue-500 text-white text-center py-2 px-4 rounded-lg hover:bg-blue-600 transition">
                                Voir les produits
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $categories->links() }}
            </div>
        </div>
    </div>
</x-app-layout> 