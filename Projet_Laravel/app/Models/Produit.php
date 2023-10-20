<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'prix',
        'description',
        'catégorie',
        'image',
        'stock',
    ];

    public function paniers()
    {
        return $this->hasMany(Panier::class);
    }
}
