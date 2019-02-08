<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\MenuItem;

class MenuType extends Model
{
    protected $fillable = [
        'name',
    ];

    public function menuItems()
    {
        return $this->hasMany(MenuItem::class, 'menutype_id', 'id');
    }
}
