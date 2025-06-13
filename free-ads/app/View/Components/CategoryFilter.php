<?php

namespace App\View\Components;

use App\Models\Category;
use Illuminate\View\Component;

class CategoryFilter extends Component
{
    public $categories;
    public $selected;
    public $name;
    public $label;

    public function __construct($selected = null, $name = 'category_id', $label = 'Catégorie')
    {
        $this->categories = Category::all();
        $this->selected = $selected;
        $this->name = $name;
        $this->label = $label;
    }

    public function render()
    {
        return view('components.category-filter');
    }
}
