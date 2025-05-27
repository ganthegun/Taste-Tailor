<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'address',
        'price',
        'meals_per_week',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderFoodBoxes()
    {
        return $this->hasMany(OrderFoodBox::class);
    }

    public function foodBoxes()
    {
        return $this->belongsToMany(FoodBox::class, 'order_food_boxes')
            ->withPivot('quantity');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
