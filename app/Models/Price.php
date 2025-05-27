<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    protected $fillable = [
        'stripe_price_id',
        'product_id',
        'currency',
        'unit_amount',
        'recurring_interval',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function customers()
    {
        return $this->belongsToMany(Customer::class, 'subscriptions');
    }
}
