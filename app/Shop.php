<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Checkout;
use App\ShopSchedule;
use App\User;

class Shop extends Model
{
    public function checkouts(){
        return $this->hasMany(Checkout::class, 'shop_id', 'id');
    }

    public function shopSchedules()
    {
        return $this->hasMany(ShopSchedule::class, 'shop_id', 'id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'shop_id', 'id');
    }

    public function isOpen()
    {
        $now = Carbon::now('Europe/London');

        $schedule = ShopSchedule::where('shop_id', '=', $this->id)
            ->where('day_week', '=', strtolower($now->format('l')))
            ->first();

        $hourOpening = (int) substr($schedule->opening_time, 0, strpos($schedule->opening_time, ':'));
        $minuteOpening = (int) substr($schedule->opening_time, strpos($schedule->opening_time, ':')+1);
        $timeOpening = Carbon::create($now->year, $now->month, $now->day, $hourOpening, $minuteOpening, 00, $now->tz);
        
        $hourClosing = (int) substr($schedule->closing_time, 0, strpos($schedule->closing_time, ':'));
        $minuteClosing = (int) substr($schedule->closing_time, strpos($schedule->closing_time, ':')+1);
        $timeClosing = Carbon::create($now->year, $now->month, $now->day, $hourClosing, $minuteClosing, 00, $now->tz);

        if($this->available == false 
            || $timeOpening->diffInMinutes($now, false) < 0 
            || $timeClosing->diffInMinutes($now, false) > 0){
            return false;
        }else{
            return true;
        }
    }
}
