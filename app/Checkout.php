<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Shop;
use App\User;
use App\CheckoutItem;
use App\PaymentConfirmation;

class Checkout extends Model
{
    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function checkoutItems()
    {
        return $this->hasMany(CheckoutItem::class, 'checkout_id', 'id');
    }

    public function payment(){
        return $this->hasOne(PaymentConfirmation::class, 'checkout_id', 'id');
    }
}
