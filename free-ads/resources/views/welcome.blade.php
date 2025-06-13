<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LeMauvaisCoin</title>
    <link rel="icon" href="/public/build/assets/LeMauvaisCoin.png" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <!-- Header avec navigation -->
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto">
            <div class="flex justify-between items-center py-4 px-4 sm:px-6 lg:px-8">
                <!-- Logo -->
                <div>
                    <a href="/" class="flex items-center">
                        <span class="text-2xl font-extrabold text-orange-600">LeMauvaisCoin</span>
                    </a>
                </div>

                <!-- Boutons -->
                <div class="flex items-center space-x-4">
                    @auth
                    <a href="{{ route('annonces.create') }}"
                        class="bg-orange-600 hover:bg-orange-700 text-white font-medium py-2 px-4 rounded-md flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                clip-rule="evenodd" />
                        </svg>
                        Déposer une annonce
                    </a>
                    @else
                    <a href="{{ route('register') }}"
                        class="text-gray-700 hover:text-orange-600 font-medium py-2 px-4 rounded-md">
                        S'enregistrer
                    </a>
                    @endauth

                    @auth
                    <a href="{{ route('profile.edit') }}" class="text-gray-700 hover:text-orange-600">Mon profil</a>
                    @else
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-orange-600">Se connecter</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Barre de recherche principale -->
    <div class="bg-orange-600 py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl md:text-3xl font-bold text-white text-center mb-6">
                Trouvez la bonne affaire parmi des milliers d'annonces
            </h1>

            <div class="max-w-3xl mx-auto">
                <x-search-bar :with-categories="true" class="mb-4" />
            </div>
        </div>
    </div>

    <!-- Contenu principal -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Catégories populaires -->
        <div class="mb-10">
            <h2 class="text-xl font-semibold mb-4">Catégories populaires</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @foreach($categories ?? array_fill(0, 6, (object)['name' => 'Catégorie', 'id' => 1]) as $category)
                <a href="{{ route('annonces.index', ['category' => $category->id]) }}"
                    class="flex flex-col items-center p-4 bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow">
                    <div class="bg-orange-100 p-3 rounded-full mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" />
                        </svg>
                    </div>
                    <span class="text-sm text-center font-medium text-gray-700">{{ $category->name }}</span>
                </a>
                @endforeach
            </div>

        </div>

        <!-- Annonces récentes -->
        <div>
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Annonces récentes</h2>
                <a href="{{ route('annonces.index') }}" class="text-orange-600 hover:text-orange-700 font-medium">
                    Voir toutes les annonces
                </a>
            </div>

            @if(isset($annonces) && $annonces->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                @foreach($annonces as $annonce)
                <div class="bg-white rounded-lg overflow-hidden shadow hover:shadow-md transition-shadow">
                    <div class="relative pb-[56.25%]"> <!-- 16:9 aspect ratio -->
                        @if($annonce->mainImage)
                        <img src="{{ asset('storage/' . $annonce->mainImage) }}"
                            class="absolute inset-0 w-full h-full object-cover" alt="{{ $annonce->titre }}">
                        @else
                        <div class="w-full h-full flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        @endif
                    </div>
                    <div class="p-4">
                        <div class="flex justify-between items-start">
                            <h3 class="font-medium text-gray-900 mb-1 truncate">{{ $annonce->titre }}</h3>
                            <span class="font-bold text-orange-600">{{ number_format($annonce->prix, 0, ',', ' ') }} €</span>
                        </div>
                        <p class="text-sm text-gray-500 mb-2 truncate">{{ $annonce->ville ?? 'Non spécifié' }}</p>
                        <p class="text-sm text-gray-600 line-clamp-2">{{ Str::limit($annonce->description, 80) }}</p>
                        <a href="{{ route('annonces.show', $annonce->id) }}"
                            class="mt-3 inline-block w-full text-center py-2 border border-orange-600 text-orange-600 rounded-md hover:bg-orange-600 hover:text-white transition-colors">
                            Voir l'annonce
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 p-4 rounded-md text-center">
                Aucune annonce trouvée.
            </div>
            @endif
        </div>
    </main>

    <!-- Comment ça marche -->
    <section class="bg-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-center mb-8">Comment ça marche</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="mx-auto h-14 w-14 rounded-full bg-orange-100 flex items-center justify-center mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium mb-2">Déposez votre annonce</h3>
                    <p class="text-gray-600">C'est simple, rapide et gratuit. Décrivez votre bien en quelques clics.</p>
                </div>

                <div class="text-center">
                    <div class="mx-auto h-14 w-14 rounded-full bg-orange-100 flex items-center justify-center mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium mb-2">Échangez avec les acheteurs</h3>
                    <p class="text-gray-600">Répondez aux demandes et organisez vos rendez-vous en toute simplicité.</p>
                </div>

                <div class="text-center">
                    <div class="mx-auto h-14 w-14 rounded-full bg-orange-100 flex items-center justify-center mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium mb-2">Vendez rapidement</h3>
                    <p class="text-gray-600">Concluez votre vente et recevez votre paiement en toute sécurité.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-gray-300 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                <div>
                    <h3 class="text-white font-bold text-lg mb-3">LeMauvaisCoin</h3>
                    <p class="text-sm text-gray-400">Achetez et vendez des produits d'occasion facilement, rapidement et localement.</p>
                </div>

                <div>
                    <h3 class="text-white font-bold text-lg mb-3">Liens utiles</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white">À propos</a></li>
                        <li><a href="#" class="hover:text-white">Conditions d'utilisation</a></li>
                        <li><a href="#" class="hover:text-white">Politique de confidentialité</a></li>
                        <li><a href="#" class="hover:text-white">Nous contacter</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-white font-bold text-lg mb-3">Suivez-nous</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white">
                            <span class="sr-only">Facebook</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <span class="sr-only">Instagram</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <span class="sr-only">Twitter</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <div class="pt-6 border-t border-gray-700 text-sm text-center text-gray-400">
                <p>&copy; {{ date('Y') }} LeMauvaisCoin. Tous droits réservés.</p>
            </div>
        </div>
    </footer>
</body>

</html>