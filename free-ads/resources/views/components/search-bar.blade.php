<div {{ $attributes->merge(['class' => 'flex bg-white rounded-lg shadow-sm overflow-hidden']) }}>
    <form method="GET" action="{{ route('annonces.index') }}" class="w-full flex">
        <div class="flex-grow relative">
            <input
                type="text"
                name="q"
                placeholder="Que recherchez-vous ?"
                value="{{ request('q') }}"
                class="w-full py-3 px-4 border-0 focus:ring-orange-500 focus:border-orange-500">

            @if(request('q'))
            <a href="{{ url()->current() }}" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
            </a>
            @endif
        </div>

        @if($withCategories && isset($categories) && count($categories) > 0)
        <div class="border-l border-gray-200">
            <select name="category" class="h-full py-3 px-4 pr-4 border-0 text-sm focus:ring-orange-500 focus:border-orange-500">
            <option value="">Toutes les catégories</option>
            @foreach($categories as $category)
            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
            @endforeach
            </select>
        </div>
        @endif

        <button type="submit" class="bg-orange-600 hover:bg-orange-700 text-white py-3 px-6 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </button>
    </form>
</div>