<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'name',
        'quantity',
        'price',
        'image',
    ];

    public static function getCartCount($userId)
    {
        return self::where('user_id', $userId)->sum('quantity');
    }
}
