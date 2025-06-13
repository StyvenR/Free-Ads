<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Créer une annonce</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
            <form action="{{ route('annonces.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label>Titre</label>
                    <input type="text" name="titre" class="w-full border p-2 rounded" required>
                </div>

                <div class="mb-4">
                    <label>Description</label>
                    <textarea name="description" class="w-full border p-2 rounded" required></textarea>
                </div>

                <div class="mb-4">
                    <label>Prix (€)</label>
                    <input type="number" name="prix" step="0.01" class="w-full border p-2 rounded" required>
                </div>

                <div class="mb-4">
                    <label>Ville</label>
                    <input type="text" name="ville" class="w-full border p-2 rounded" required>
                </div>

                <div class="mb-4">
                    <x-category-filter :selected="$annonce->category_id ?? null" />
                </div>

                <div class="mb-4">
                    <label class="block font-medium mb-1">Images</label>
                    <div class="border-2 border-dashed border-gray-300 rounded-md px-6 py-10 relative">
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

                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Créer</button>
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
    </script>
    @endpush
</x-app-layout>