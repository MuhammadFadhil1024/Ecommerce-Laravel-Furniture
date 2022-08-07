<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_users', 'id_products'
    ];

    public function product()
    {
        return $this->hasOne(product::class, 'id', 'id_products');
    }

    public function user()
    {
        return $this->belongsTo(Users::class, 'id_users', 'id');
    }
}
