<?php
// app/Models/Annonce.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AnnonceImage;
use App\Models\Category;

class Annonce extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'description',
        'prix',
        'ville',
        'image',
        'user_id',
        'category_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(AnnonceImage::class)->orderBy('position');
    }

    public function primaryImage()
    {
        return $this->hasOne(AnnonceImage::class)->where('is_primary', true);
    }

    public function getMainImageAttribute()
    {
        // D'abord essayer de récupérer l'image marquée comme principale
        $primaryImage = $this->primaryImage()->first();

        if ($primaryImage) {
            return $primaryImage->path;
        }

        // Sinon prendre la première image disponible
        $firstImage = $this->images()->first();

        if ($firstImage) {
            return $firstImage->path;
        }

        // Si pas d'image dans la nouvelle structure, vérifier l'ancien champ
        if ($this->image) {
            return $this->image;
        }

        // Pas d'image du tout
        return null;
    }
}
