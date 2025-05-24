<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'name',
        'description',
        'nutrient',
        'price',
        'image',
    ];

    public function boxMenus()
    {
        return $this->hasMany(BoxMenu::class);
    }

    public function foodBoxes()
    {
        return $this->belongsToMany(FoodBox::class, 'box_menus');
    }
}
