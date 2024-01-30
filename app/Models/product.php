<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'price', 'description', 'slug', 'stock', 'weight'
    ];

    public function galleries()
    {
        return $this->hasMany(ProductGallery::class, 'id_products', 'id');
    }
}
