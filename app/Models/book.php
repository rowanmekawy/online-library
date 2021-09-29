<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class book extends Model
{
    use HasFactory;
    protected $fillable=['name',
    'author',
    'summary',
    'pdf',
    'cover_image',
    'price',
];

}
