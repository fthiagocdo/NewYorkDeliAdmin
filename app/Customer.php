<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Shop;
use App\Checkout;

class Customer extends Model
{
    public function checkouts(){
        return $this->hasMany(Checkout::class, 'user_id', 'id');
    }
}
