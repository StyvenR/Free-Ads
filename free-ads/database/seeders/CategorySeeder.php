<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Véhicules',
                'icon' => 'car',
                'description' => 'Voitures, motos, caravanes et plus'
            ],
            [
                'name' => 'Immobilier',
                'icon' => 'home',
                'description' => 'Appartements, maisons, terrains à vendre ou à louer'
            ],
            [
                'name' => 'Emploi',
                'icon' => 'briefcase',
                'description' => 'Offres d\'emploi et services'
            ],
            [
                'name' => 'Mode',
                'icon' => 'tshirt',
                'description' => 'Vêtements, chaussures, accessoires, bijoux'
            ],
            [
                'name' => 'Multimédia',
                'icon' => 'laptop',
                'description' => 'Téléphones, ordinateurs, TV, consoles de jeux'
            ],
            [
                'name' => 'Maison',
                'icon' => 'couch',
                'description' => 'Meubles, électroménager, décoration'
            ],
            [
                'name' => 'Loisirs',
                'icon' => 'ticket',
                'description' => 'Sports, hobbies, instruments de musique, voyages'
            ],
            [
                'name' => 'Animaux',
                'icon' => 'paw',
                'description' => 'Animaux et accessoires'
            ]
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
                'icon' => $category['icon'],
                'is_active' => true
            ]);
        }
    }
}
