<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\MenuItem;

class MenuExtra extends Model
{
    protected $table = 'menu_extras';

    public function menuItem()
    {
        return $this->belongsTo(MenuItem::class, 'menuitem_id');
    }
}
