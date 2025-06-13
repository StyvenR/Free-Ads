<?php

namespace App\View\Components;

use App\Models\Category;
use Illuminate\View\Component;

class SearchBar extends Component
{
    public $categories;
    public $withCategories;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($withCategories = false)
    {
        $this->withCategories = $withCategories;

        if ($withCategories) {
            // Récupérer seulement les catégories actives
            $this->categories = Category::where('is_active', true)->get();

            // Si aucune catégorie n'est trouvée, récupérer toutes les catégories
            if ($this->categories->isEmpty()) {
                $this->categories = Category::all();
            }
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.search-bar');
    }
}
