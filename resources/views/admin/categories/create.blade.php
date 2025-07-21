<x-admin-layout>
    <div class="space-y-6">
        <!-- Header -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Ajouter une Catégorie</h1>
                        <p class="text-gray-600">Créez une nouvelle catégorie pour organiser vos produits</p>
                    </div>
                    <a href="{{ route('admin.categories.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Retour
                    </a>
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div>
                            <x-input-label for="name" :value="__('Nom de la catégorie')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Image -->
                        <div>
                            <x-input-label for="image" :value="__('Image')" />
                            <input id="image" class="block mt-1 w-full" type="file" name="image" accept="image/*" />
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>

                        <!-- Description -->
                        <div class="md:col-span-2">
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" name="description" rows="4" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <x-primary-button class="ml-3">
                            {{ __('Créer la catégorie') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout> 