<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'is_active'
    ];

    /**
     * Les attributs qui devraient être castés.
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Relation avec les annonces appartenant à cette catégorie
     */
    public function annonces()
    {
        return $this->hasMany(Annonce::class);
    }

    /**
     * Obtenir le nombre d'annonces actives dans cette catégorie
     */
    public function getAnnonceCountAttribute()
    {
        return $this->annonces()->count();
    }

    /**
     * Scope pour ne récupérer que les catégories actives
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
