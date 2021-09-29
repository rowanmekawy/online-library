<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_book_cart extends Model
{
    use HasFactory;
    protected $fillable=['id',
    'user_id',
    'cart_id',
    'book_id',
    'promo_id',
    'price',
];

}
