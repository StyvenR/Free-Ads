<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center mb-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Liste des annonces
            </h2>
        </div>
        <x-search-bar :with-categories="true" class="mt-4" />
    </x-slot>

    <div class="py-6">
        <!-- Liste des annonces -->
        <div class="space-y-6">
            @forelse ($annonces as $annonce)
            <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow overflow-hidden">
                <div class="md:flex">
                    <!-- Image -->
                    <div class="md:w-1/4 p-4">
                        <div class="aspect-w-4 aspect-h-3 bg-gray-100 rounded-md overflow-hidden">
                            @if($annonce->mainImage)
                            <img src="{{ asset('storage/' . $annonce->mainImage) }}"
                                class="w-full h-full object-cover" alt="{{ $annonce->titre }}">
                            @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Contenu -->
                    <div class="md:w-3/4 p-4 md:border-l border-gray-100">
                        <div class="flex justify-between">
                            <h2 class="text-xl font-bold text-gray-800">{{ $annonce->titre }}</h2>
                            <p class="font-bold text-lg text-orange-600">{{ number_format($annonce->prix, 0, ',', ' ') }} €</p>
                        </div>

                        <div class="flex items-center text-gray-500 text-sm mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span>{{ $annonce->ville }}</span>

                            <span class="mx-2">•</span>

                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ $annonce->created_at->diffForHumans() }}</span>
                        </div>

                        <p class="mt-3 text-gray-600">{{ Str::limit($annonce->description, 150) }}</p>

                        <div class="mt-4 flex flex-wrap gap-2">
                            <a href="{{ route('annonces.show', $annonce) }}"
                                class="px-4 py-2 bg-white border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors">
                                Voir le détail
                            </a>
                            @if(auth()->check() && auth()->id() === $annonce->user_id)
                            <a href="{{ route('annonces.edit', $annonce) }}"
                                class="px-4 py-2 bg-yellow-50 border border-yellow-300 rounded-md text-yellow-700 hover:bg-yellow-100 transition-colors">
                                Modifier
                            </a>
                            <form action="{{ route('annonces.destroy', $annonce) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette annonce ?')"
                                    class="px-4 py-2 bg-red-50 border border-red-300 rounded-md text-red-700 hover:bg-red-100 transition-colors">
                                    Supprimer
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="bg-yellow-50 border border-yellow-200 p-6 rounded-lg text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-yellow-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <p class="text-lg font-medium text-yellow-800">Aucune annonce trouvée</p>
                <p class="text-yellow-600 mt-1">Commencez par créer une nouvelle annonce</p>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if(method_exists($annonces, 'links') && $annonces->hasPages())
        <div class="mt-6">
            {{ $annonces->links() }}
        </div>
        @endif
    </div>
    </div>
</x-app-layout>