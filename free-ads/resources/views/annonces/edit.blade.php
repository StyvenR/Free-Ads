<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Modifier l'annonce : {{ $annonce->titre }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
            <form action="{{ route('annonces.update', $annonce) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label>Titre</label>
                    <input type="text" name="titre" class="w-full border p-2 rounded"
                        value="{{ old('titre', $annonce->titre) }}" required>
                </div>

                <div class="mb-4">
                    <label>Description</label>
                    <textarea name="description" class="w-full border p-2 rounded" required>{{ old('description', $annonce->description) }}</textarea>
                </div>

                <div class="mb-4">
                    <label>Prix (€)</label>
                    <input type="number" step="0.01" name="prix" class="w-full border p-2 rounded"
                        value="{{ old('prix', $annonce->prix) }}" required>
                </div>

                <div class="mb-4">
                    <label>Ville</label>
                    <input type="text" name="ville" class="w-full border p-2 rounded"
                        value="{{ old('ville', $annonce->ville) }}" required>
                </div>
                <div class="mb-4">
                    <x-category-filter :selected="$annonce->category_id ?? null" />
                </div>

                <!-- Images actuelles -->
                <div class="mb-6">
                    <label class="block font-medium mb-2">Images actuelles</label>

                    @if($annonce->images->count() > 0)
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                        @foreach($annonce->images as $image)
                        <div class="relative border rounded-md overflow-hidden group">
                            <img src="{{ asset('storage/' . $image->path) }}" class="w-full h-32 object-cover" alt="">

                            <div class="absolute inset-0 bg-black bg-opacity-40 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col items-center justify-center">
                                <!-- Bouton de suppression explicite -->
                                <button type="button"
                                    class="w-8 h-8 rounded-full bg-white flex items-center justify-center"
                                    onclick="toggleImageDeletion('{{ $image->id }}', this)">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 delete-icon-{{ $image->id }}" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <input type="hidden" name="delete_images[]" id="delete-{{ $image->id }}" disabled>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <p class="text-sm text-gray-500 mt-1">Étoile : image principale / Corbeille : supprimer l'image</p>
                    @elseif($annonce->image)
                    <div class="border rounded-md p-2">
                        <img src="{{ asset('storage/' . $annonce->image) }}" class="w-32 h-auto" alt="Image actuelle">
                    </div>
                    @else
                    <p class="text-gray-500">Aucune image</p>
                    @endif
                </div>

                <!-- Ajout de nouvelles images -->
                <div class="mb-4">
                    <label class="block font-medium mb-1">Ajouter des images</label>
                    <div class="border-2 border-dashed border-gray-300 rounded-md px-6 py-6 relative">
                        <input type="file" name="images[]" id="images" multiple
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                            accept="image/*" onchange="previewImages(this)">
                        <div class="text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <p class="mt-1 text-sm text-gray-600">Cliquez ou glissez-déposez des images</p>
                            <p class="mt-1 text-xs text-gray-500">PNG, JPG, GIF jusqu'à 2MB</p>
                        </div>
                    </div>

                    <!-- Aperçu des images sélectionnées -->
                    <div id="image-previews" class="grid grid-cols-3 gap-4 mt-4"></div>
                </div>

                <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded">
                    Enregistrer les modifications
                </button>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function previewImages(input) {
            const previewContainer = document.getElementById('image-previews');
            previewContainer.innerHTML = '';

            if (input.files) {
                Array.from(input.files).forEach(file => {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        const previewDiv = document.createElement('div');
                        previewDiv.className = 'relative aspect-w-1 aspect-h-1 bg-gray-100 rounded-md overflow-hidden';

                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'w-full h-full object-cover';

                        previewDiv.appendChild(img);
                        previewContainer.appendChild(previewDiv);
                    };

                    reader.readAsDataURL(file);
                });
            }
        }

        // Fonction pour gérer la suppression d'images
        function toggleImageDeletion(imageId, button) {
            const input = document.getElementById('delete-' + imageId);
            const icon = button.querySelector('.delete-icon-' + imageId);

            if (input.disabled) {
                // Marquer pour suppression
                input.disabled = false;
                input.value = imageId;
                icon.classList.remove('text-gray-400');
                icon.classList.add('text-red-500');
                button.closest('.relative').classList.add('opacity-50');
            } else {
                // Annuler la suppression
                input.disabled = true;
                input.value = '';
                icon.classList.add('text-gray-400');
                icon.classList.remove('text-red-500');
                button.closest('.relative').classList.remove('opacity-50');
            }
        }
    </script>
    @endpush
</x-app-layout>