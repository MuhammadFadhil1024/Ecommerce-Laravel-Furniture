<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id_users', 'name', 'email', 'address', 'phone', 'courier',
        'payment', 'payment_url', 'total_price', 'status'
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'id_users', 'id');
    }
}
