<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'price',
        'description',
        'image',
        'stock',
    ];

    public function shopBaskets()
    {
        return $this->hasMany(shopBasket::class);
    }
}