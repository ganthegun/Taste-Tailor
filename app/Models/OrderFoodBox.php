<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderFoodBox extends Model
{
    protected $fillable = [
        'order_id',
        'food_box_id',
        'quantity',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function foodBox()
    {
        return $this->belongsTo(FoodBox::class);
    }
}
