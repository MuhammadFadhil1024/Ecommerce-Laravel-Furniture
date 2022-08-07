<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_products', 'id_users', 'id_transactions'
    ];

    public function product()
    {
        return $this->hasOne(product::class, 'id', 'id_products');
    }
}
