<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            🎤 Démonstration de la Recherche Vocale
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Introduction -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-4">
                        🎤 Recherche Vocale des Produits
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">
                        Découvrez notre fonctionnalité de recherche vocale révolutionnaire ! Utilisez votre voix pour rechercher des produits dans notre catalogue.
                    </p>
                    
                    <!-- Fonctionnalités -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div class="text-center p-4 bg-blue-50 rounded-lg">
                            <div class="text-3xl mb-2">🎯</div>
                            <h3 class="font-semibold text-gray-900">Recherche Précise</h3>
                            <p class="text-sm text-gray-600">Recherchez par nom, description ou catégorie</p>
                        </div>
                        <div class="text-center p-4 bg-green-50 rounded-lg">
                            <div class="text-3xl mb-2">🔊</div>
                            <h3 class="font-semibold text-gray-900">Reconnaissance Vocale</h3>
                            <p class="text-sm text-gray-600">Technologie Annyang.js pour une reconnaissance optimale</p>
                        </div>
                        <div class="text-center p-4 bg-purple-50 rounded-lg">
                            <div class="text-3xl mb-2">⚡</div>
                            <h3 class="font-semibold text-gray-900">Résultats Instantanés</h3>
                            <p class="text-sm text-gray-600">Affichage en temps réel des produits trouvés</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Instructions -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-4">
                        📋 Comment utiliser la recherche vocale
                    </h2>
                    
                    <div class="space-y-4">
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0 w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center text-sm font-bold">1</div>
                            <div>
                                <h3 class="font-semibold text-gray-900 dark:text-gray-100">Cliquez sur le bouton "Recherche vocale"</h3>
                                <p class="text-gray-600 dark:text-gray-400">Le bouton se trouve à côté de la barre de recherche</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0 w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center text-sm font-bold">2</div>
                            <div>
                                <h3 class="font-semibold text-gray-900 dark:text-gray-100">Autorisez l'accès au microphone</h3>
                                <p class="text-gray-600 dark:text-gray-400">Votre navigateur vous demandera l'autorisation</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0 w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center text-sm font-bold">3</div>
                            <div>
                                <h3 class="font-semibold text-gray-900 dark:text-gray-100">Prononcez votre recherche</h3>
                                <p class="text-gray-600 dark:text-gray-400">Exemples : "recherche Red Bull", "cherche café", "trouve clavier"</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0 w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center text-sm font-bold">4</div>
                            <div>
                                <h3 class="font-semibold text-gray-900 dark:text-gray-100">Consultez les résultats</h3>
                                <p class="text-gray-600 dark:text-gray-400">Les produits trouvés s'affichent instantanément</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Commandes vocales -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-4">
                        🗣️ Commandes vocales disponibles
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <h3 class="font-semibold text-gray-900 mb-2">Recherche de produits</h3>
                            <ul class="space-y-1 text-sm text-gray-600">
                                <li>• "recherche [nom du produit]"</li>
                                <li>• "cherche [nom du produit]"</li>
                                <li>• "trouve [nom du produit]"</li>
                            </ul>
                        </div>
                        
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <h3 class="font-semibold text-gray-900 mb-2">Contrôle</h3>
                            <ul class="space-y-1 text-sm text-gray-600">
                                <li>• "arrête" - Arrêter l'écoute</li>
                                <li>• "stop" - Arrêter l'écoute</li>
                                <li>• "pause" - Mettre en pause</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            
        </div>
    </div>

    
</x-app-layout> 