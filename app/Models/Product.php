<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'stripe_product_id',
        'order_id',
        'name',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function prices()
    {
        return $this->hasMany(Price::class);
    }
}
