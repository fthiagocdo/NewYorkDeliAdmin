<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\MenuType;
use App\MenuExtra;

class MenuItem extends Model
{
    protected $table = 'menu_items';

    public function type()
    {
        return $this->belongsTo(MenuType::class, 'menutype_id');
    }

    public function menuExtras()
    {
        return $this->hasMany(MenuExtra::class, 'menuitem_id', 'id');
    }
}
