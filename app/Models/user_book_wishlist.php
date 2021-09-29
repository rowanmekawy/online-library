<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_book_wishlist extends Model
{
    use HasFactory;
    protected $fillable=['id',
    'user_id',
    'wishlist_id',
    'book_id',
    'promo_id',
    'price',
];
}
