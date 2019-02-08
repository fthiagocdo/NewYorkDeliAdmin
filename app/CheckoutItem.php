<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Checkout;
use App\CheckoutItemExtra;
use App\MenuItem;

class CheckoutItem extends Model
{
    protected $table = 'checkout_items';

    public function checkout()
    {
        return $this->belongsTo(Checkout::class, 'checkout_id');
    }

    public function menuItem()
    {
        return $this->belongsTo(MenuItem::class, 'menuitem_id');
    }

    public function checkoutItemExtras()
    {
        return $this->hasMany(CheckoutItemExtra::class, 'checkoutitem_id', 'id');
    }
}
