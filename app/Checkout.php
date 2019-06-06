<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Shop;
use App\Customer;
use App\CheckoutItem;
use App\PaymentConfirmation;

class Checkout extends Model
{
    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id')->first();
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function checkoutItems()
    {
        return $this->hasMany(CheckoutItem::class, 'checkout_id', 'id');
    }

    public function payment(){
        return $this->hasOne(PaymentConfirmation::class, 'checkout_id', 'id');
    }
}
