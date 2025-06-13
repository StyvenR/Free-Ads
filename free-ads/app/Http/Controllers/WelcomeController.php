<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Annonce;
use App\Models\Category;

class WelcomeController extends Controller
{
  public function index()
  {
    $categories = Category::all();
    $annonces = Annonce::latest()->take(8)->get();
    return view('welcome', compact('categories', 'annonces'));
  }
}
