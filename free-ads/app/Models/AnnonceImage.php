<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnnonceImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'annonce_id',
        'path',
        'is_primary',
        'position'
    ];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    public function annonce()
    {
        return $this->belongsTo(Annonce::class);
    }

    public function getUrlAttribute()
    {
        return asset('storage/' . $this->path);
    }
}
