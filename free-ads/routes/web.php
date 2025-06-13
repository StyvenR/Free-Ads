<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AnnonceController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
});

Route::resource('annonces', AnnonceController::class);

// Routes pour les annonces
Route::resource('annonces', AnnonceController::class);

// Ajouter cette route pour gérer la réorganisation des images
Route::post('annonces/{annonce}/reorder-images', [App\Http\Controllers\AnnonceController::class, 'reorderImages'])
    ->name('annonces.reorderImages')
    ->middleware('auth');

// Routes pour la recherche
Route::get('/search', [AnnonceController::class, 'index'])->name('search');

require __DIR__ . '/auth.php';
