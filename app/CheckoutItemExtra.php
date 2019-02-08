<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\CheckoutItem;
use App\MenuExtra;

class CheckoutItemExtra extends Model
{
	protected $table = 'checkout_item_extras';

    public function checkoutItem()
    {
        return $this->belongsTo(CheckoutItem::class, 'checkoutitem_id');
    }

    public function menuExtra()
    {
        return $this->belongsTo(MenuExtra::class, 'menuextra_id');
    }
}
