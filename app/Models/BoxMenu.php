<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoxMenu extends Model
{
    protected $fillable = [
        'food_box_id',
        'menu_id',
    ];

    public function foodBox()
    {
        return $this->belongsTo(FoodBox::class);
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
