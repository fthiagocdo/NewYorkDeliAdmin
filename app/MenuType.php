<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\MenuItem;
use App\Shop;

class MenuType extends Model
{
    protected $fillable = [
        'shop_id',
        'name',
    ];

    public function menuItems()
    {
        return $this->hasMany(MenuItem::class, 'menutype_id', 'id');
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id');
    }
}
