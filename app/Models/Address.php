<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name', 'user_id', 'telphone_number', 'provinces', 'city', 'is_active', 'type_of_place', 'detail_address'
    ];
}
