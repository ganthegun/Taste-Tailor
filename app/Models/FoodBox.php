<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoodBox extends Model
{
    protected $fillable = [
        'name',
        'description',
        'dietary_preference',
        'total_price',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function boxMenus()
    {
        return $this->hasMany(BoxMenu::class);
    }

    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'box_menus');
    }
}
