<x-admin-layout>
    <div class="space-y-6">
        <!-- Header -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Gestion des Produits</h1>
                        <p class="text-gray-600">Gérez tous les produits de votre boutique</p>
                    </div>
                    <a href="{{ route('admin.products.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Ajouter un Produit
                    </a>
                </div>
            </div>
        </div>

        <!-- Products Table -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Produit
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Catégorie
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Prix
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Stock
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($products as $product)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-lg bg-gray-200 flex items-center justify-center">
                                                    <span class="text-xs text-gray-500">IMG</span>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $product->name }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ Str::limit($product->description, 50) }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $product->category->name }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ number_format($product->price, 2) }} €
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $product->stock }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('admin.products.edit', $product) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                            Modifier
                                        </a>
                                        <form method="POST" action="{{ route('admin.products.destroy', $product) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')">
                                                Supprimer
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                        Aucun produit trouvé
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($products->hasPages())
                    <div class="mt-6">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-admin-layout> 