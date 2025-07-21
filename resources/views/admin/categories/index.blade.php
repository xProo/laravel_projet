<x-admin-layout>
    <div class="space-y-6">
        <!-- Header -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Gestion des Catégories</h1>
                        <p class="text-gray-600">Gérez toutes les catégories de votre boutique</p>
                    </div>
                    <a href="{{ route('admin.categories.create') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        Ajouter une Catégorie
                    </a>
                </div>
            </div>
        </div>

        <!-- Categories Table -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Catégorie
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Description
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Produits
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Créée le
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($categories as $category)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-lg bg-green-200 flex items-center justify-center">
                                                    <span class="text-green-800 font-medium">{{ strtoupper(substr($category->name, 0, 2)) }}</span>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $category->name }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">
                                            {{ Str::limit($category->description, 100) }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $category->products_count ?? 0 }} produit(s)
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $category->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('admin.categories.edit', $category) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                            Modifier
                                        </a>
                                        <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?')">
                                                Supprimer
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                        Aucune catégorie trouvée
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($categories->hasPages())
                    <div class="mt-6">
                        {{ $categories->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-admin-layout> 