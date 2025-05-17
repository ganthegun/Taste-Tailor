<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoodBox extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'dietary_preference',
        'image_url',
        // 'created_at',
        // 'updated_at',
        'user_id',
        'food_items',
    ];
}
