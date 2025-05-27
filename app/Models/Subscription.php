<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'stripe_subscription_id',
        'customer_id',
        'price_id',
    ];

    public function prices()
    {
        return $this->belongsTo(Price::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class,);
    }
}
