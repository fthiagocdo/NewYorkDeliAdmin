<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Checkout;

class PaymentConfirmation extends Model
{
    public function checkout(){
        return $this->belongsTo(Checkout::class, 'checkout_id');
    }
}
