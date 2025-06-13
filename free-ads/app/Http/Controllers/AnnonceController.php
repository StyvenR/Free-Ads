<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\Category;
use App\Models\AnnonceImage;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class AnnonceController extends Controller
{
    public function index(Request $request)
    {
        $query = Annonce::query();

        // Recherche par mot-clé
        if ($request->has('q') && !empty($request->q)) {
            $searchTerm = $request->q;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('titre', 'like', "%{$searchTerm}%")
                    ->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }

        // Filtrage par catégorie
        if ($request->has('category') && !empty($request->category)) {
            $query->where('category_id', $request->category);
        }

        $annonces = $query->latest()->paginate(12);
        $categories = Category::all();

        return view('annonces.index', compact('annonces', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('annonces.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required',
            'description' => 'required',
            'prix' => 'required|numeric',
            'ville' => 'required',
            'images.*' => 'nullable|image|max:2048',
            'category_id' => 'nullable|exists:categories,id'
        ]);

        // Créer l'annonce
        $data = $request->except('images');
        $data['user_id'] = Auth::id();

        $annonce = Annonce::create($data);

        // Traitement des images multiples
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $imageFile) {
                $imagePath = $imageFile->store('annonces', 'public');

                AnnonceImage::create([
                    'annonce_id' => $annonce->id,
                    'path' => $imagePath,
                    'is_primary' => $index === 0, // La première image est principale
                    'position' => $index
                ]);
            }
        }
        // Compatibilité avec l'ancien champ image
        elseif ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('annonces', 'public');

            // Enregistrer l'image comme image principale
            AnnonceImage::create([
                'annonce_id' => $annonce->id,
                'path' => $imagePath,
                'is_primary' => true,
                'position' => 0
            ]);

            // Conserver aussi dans l'ancien champ pour compatibilité
            $annonce->image = $imagePath;
            $annonce->save();
        }

        return redirect()->route('annonces.index')->with('success', 'Annonce créée avec succès');
    }

    public function show(Annonce $annonce)
    {
        return view('annonces.show', compact('annonce'));
    }

    public function edit(Annonce $annonce)
    {
        if (Auth::id() !== $annonce->user_id) {
            abort(403, 'Vous n\'êtes pas autorisé à modifier cette annonce.');
        }

        $categories = Category::all();
        return view('annonces.edit', compact('annonce', 'categories'));
    }

    public function update(Request $request, Annonce $annonce)
    {
        // Vérifier si l'utilisateur peut modifier l'annonce
        if (Auth::id() !== $annonce->user_id) {
            abort(403, 'Vous n\'êtes pas autorisé à modifier cette annonce.');
        }

        $request->validate([
            'titre' => 'required',
            'description' => 'required',
            'prix' => 'required|numeric',
            'ville' => 'required',
            'images.*' => 'nullable|image|max:2048',
            'delete_images' => 'nullable|array',
            'delete_images.*' => 'exists:annonce_images,id',
            'primary_image' => 'nullable|exists:annonce_images,id',
            'category_id' => 'nullable|exists:categories,id'
        ]);

        // Mise à jour des données de base
        $annonce->update($request->except(['_token', '_method', 'images', 'delete_images', 'primary_image']));

        // Supprimer les images sélectionnées
        if ($request->has('delete_images')) {
            AnnonceImage::whereIn('id', $request->delete_images)->delete();
        }

        // Ajouter de nouvelles images
        if ($request->hasFile('images')) {
            $maxPosition = $annonce->images()->max('position') ?? -1;

            foreach ($request->file('images') as $imageFile) {
                $maxPosition++;
                $imagePath = $imageFile->store('annonces', 'public');

                AnnonceImage::create([
                    'annonce_id' => $annonce->id,
                    'path' => $imagePath,
                    'position' => $maxPosition
                ]);
            }
        }
        // Compatibilité avec l'ancien champ image
        elseif ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('annonces', 'public');

            // Enregistrer comme nouvelle image
            AnnonceImage::create([
                'annonce_id' => $annonce->id,
                'path' => $imagePath,
                'is_primary' => true,
                'position' => $annonce->images()->max('position') + 1 ?? 0
            ]);

            // Conserver aussi dans l'ancien champ pour compatibilité
            $annonce->image = $imagePath;
            $annonce->save();
        }

        // Définir l'image principale
        if ($request->has('primary_image')) {
            $annonce->images()->update(['is_primary' => false]);

            AnnonceImage::where('id', $request->primary_image)
                ->where('annonce_id', $annonce->id)
                ->update(['is_primary' => true]);
        }

        return redirect()->route('annonces.show', $annonce)->with('success', 'Annonce mise à jour avec succès');
    }

    public function destroy(Annonce $annonce)
    {
        if (Auth::id() == $annonce->user_id) {
            $annonce->delete();
        }

        return redirect()->route('annonces.index')->with('success', 'Annonce supprimée avec succès');
    }
}
