<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Shop;

class ShopSchedule extends Model
{
	protected $table = 'shop_schedules';

    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id');
    }
}
