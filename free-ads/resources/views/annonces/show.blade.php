<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $annonce->titre }}</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
            <!-- Galerie d'images -->
            @if($annonce->images->count() > 0)
            <div class="mb-6">
                <div class="aspect-w-16 aspect-h-9 bg-gray-100 rounded-md overflow-hidden mb-2">
                    <img id="main-image" src="{{ asset('storage/' . $annonce->mainImage) }}"
                        class="w-full h-full object-contain" alt="{{ $annonce->titre }}">
                </div>

                @if($annonce->images->count() > 1)
                <div class="grid grid-cols-6 gap-2">
                    @foreach($annonce->images as $image)
                    <div class="aspect-w-1 aspect-h-1 bg-gray-100 rounded-md overflow-hidden cursor-pointer 
                                          hover:opacity-80 transition-opacity {{ $image->is_primary ? 'ring-2 ring-orange-500' : '' }}"
                        onclick="changeMainImage('{{ asset('storage/' . $image->path) }}')">
                        <img src="{{ asset('storage/' . $image->path) }}" class="w-full h-full object-cover" alt="">
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
            @elseif($annonce->image)
            <img src="{{ asset('storage/' . $annonce->image) }}" class="w-full h-auto mb-4 rounded">
            @endif

            <p><strong>Description :</strong> {{ $annonce->description }}</p>
            <p><strong>Prix :</strong> {{ $annonce->prix }} €</p>
            <p><strong>Ville :</strong> {{ $annonce->ville }}</p>

            <a href="{{ route('annonces.index') }}" class="inline-block mt-4 text-blue-600">← Retour aux annonces</a>
        </div>
    </div>

    @push('scripts')
    <script>
        function changeMainImage(src, element) {
            document.getElementById('main-image').src = src;
            // Remove ring from all thumbnails
            document.querySelectorAll('.ring-2').forEach(el => {
                el.classList.remove('ring-2', 'ring-orange-500');
            });
            // Add ring to selected thumbnail
            element.classList.add('ring-2', 'ring-orange-500');
        }
    </script>
    @endpush
</x-app-layout>