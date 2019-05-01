<?php

namespace App\Business;

use Exception;
use GoogleMaps;
use PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Util\Util;
use App\Checkout;
use App\Shop;
use App\ShopSchedule;
use App\User;
use App\MenuItem;
use App\CheckoutItem;
use App\CheckoutItemExtra;
use App\PaymentConfirmation;

class OrderBusiness
{
    public static function listOrderHistory($user_id, $shop_id)
	{
        try{
			$registers = Checkout::where('user_id', '=', $user_id)
				->where('shop_id', '=', $shop_id)
				->where('confirmed', '=', true)
				->orderBy('updated_at', 'desc')
                ->get();
                
            $listOrders = collect();
            foreach($registers as $register){
                $register['payment'] = $register->payment()->first();
                $listOrders->push($register);
            }

			$return['error'] = false;
            $return['list'] = $listOrders;
            return $return;
        }catch(Exception $e){
            Log::error('OrderBusiness.listOrderHistory: '.$e->getMessage());
            $return['error'] = true;
            $return['message'] = 'It was no possible complete your request. Please try again later...';
            return $return;
        }
    }

    public static function getOrderDetails($id)
	{
        try{
            $checkout = Checkout::find($id);

            //order -> checkoutItem
            $listcheckoutItem = collect();
            foreach ($checkout->checkoutItems as $checkoutItem) {
                $itemMenu['id'] = $checkoutItem->id;
                $itemMenu['name'] = $checkoutItem->menuItem->name;
                $itemMenu['price'] = $checkoutItem->unitary_price;
                $itemMenu['type'] = $checkoutItem->menuItem->type->name;
                $itemMenu['quantity'] = $checkoutItem->quantity;
                $itemMenu['totalValue'] = $checkoutItem->total_price;
                
                //order -> checkoutItem -> checkoutItemExtra
                $listcheckoutItemExtra = collect();
                foreach ($checkoutItem->checkoutItemExtras as $checkoutItemExtra) {
                    $itemExtra['name'] = $checkoutItemExtra->menuExtra->name;
                    $itemExtra['price'] = $checkoutItemExtra->menuExtra->price;

                    $listcheckoutItemExtra->push($itemExtra);
                }
                $itemMenu['checkoutItemExtras'] = $listcheckoutItemExtra;
                $listcheckoutItem->push($itemMenu);
            }

            $checkout['menu_items'] = $listcheckoutItem;
            $checkout['payment'] = $checkout->payment()->first();
            
            $return['error'] = false;
            $return['order'] = $checkout;
            return $return;
        }catch(Exception $e){
            Log::error('OrderBusiness.getOrderDetails: '.$e->getMessage());
            $return['error'] = true;
            $return['message'] = $e->getMessage();//'It was no possible complete your request. Please try again later...';
            return $return;
        }
	}
}