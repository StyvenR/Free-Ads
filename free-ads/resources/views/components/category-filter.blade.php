<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700 mb-1">{{ $label ?? 'Catégorie' }}</label>
    <select name="{{ $name ?? 'category_id' }}" class="w-full border border-gray-300 rounded-md p-2">
        <option value="">Sélectionnez une catégorie</option>
        @foreach($categories ?? \App\Models\Category::all() as $category)
            <option value="{{ $category->id }}" {{ $selected == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
</div>