<?php

namespace App\Business;

use \Exception;
use Illuminate\Support\Facades\Log;
use App\Checkout;
use App\Shop;
use App\User;
use App\MenuItem;
use App\CheckoutItem;
use App\CheckoutItemExtra;

class CheckoutBusiness
{
    public static function shoppingCart($user_id)
	{
        try{
            $shops = Shop::all();
            $checkout = CheckoutBusiness::findOrCreateCheckout($user_id);

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
            
            $return['error'] = false;
            $return['message'] = 'OK';
            $return['checkout'] = $checkout;
            return $return;
        }catch(Exception $e){
            Log::error('CheckoutBusiness.shoppingCart: '.$e->getMessage());
            $return['error'] = true;
            $return['message'] = 'It was no possible complete your request. Please try again later...';
            return $return;
        }
    }
    
    private static function findOrCreateCheckout($user_id)
	{
        try{
            $user = User::find($user_id);
            $checkout = Checkout::where('user_id', '=', $user->id)
                ->where('confirmed', '=', false)
                ->first();
            
            if(!isset($checkout)){
                $checkout = new Checkout();
                $checkout->user_id = $user->id;
                $checkout->partial_value = 0.0;
                $checkout->total_value = 2;
                $checkout->delivery_fee = 2;
                $checkout->rider_tip = 0.0;
                $checkout->shop_id = $user->shop_id;
                
                $checkout->save();
            }
            
            if($checkout->shop != null && !$checkout->shop->isOpen()){
                $checkout->shop_id = null;
            }

            return $checkout;
        }catch(Exception $e){
            Log::error('CheckoutBusiness.findOrCreateCheckout: '.$e->getMessage());
            $return['error'] = true;
            $return['message'] = 'It was no possible complete your request. Please try again later...';
            return $return;
        }
    }
    
    public static function addItem($data, $user_id)
    {   	
        $return = CheckoutBusiness::shoppingCart($user_id);
        if($return['error']){
            return $return;
        }else{
            try{
                $checkout = $return['checkout'];
                $menuItem = MenuItem::find($data['menuitem_id']);
                $totalValueItem = 0.0;
                $checkoutItem = new CheckoutItem();
                $checkoutItem->checkout_id = $checkout->id;
                $checkoutItem->menuitem_id = $menuItem->id;
                $checkoutItem->unitary_price = $menuItem->price;
                $checkoutItem->total_price = $menuItem->price;
                $checkoutItem->quantity = 1;
                $checkoutItem->save();

                $totalValueItem = $checkoutItem->total_price;

                //verifies if it has extras
                $menuExtras = $menuItem->menuExtras;
                foreach ($menuExtras as $menuExtra) {
                    if(isset($data['menuextra_'.$menuExtra->id])){
                        $checkoutItemExtra = new CheckoutItemExtra();
                        $checkoutItemExtra->checkoutitem_id = $checkoutItem->id;
                        $checkoutItemExtra->menuextra_id = $menuExtra->id;
                        $checkoutItemExtra->price = $menuExtra->price;
                        $checkoutItemExtra->save();
                        $totalValueItem += $checkoutItemExtra->price;
                    }
                }

                //if you save as double the number will be truncated. You need save it as string.
                $checkoutItem->unitary_price = (string) $totalValueItem;
                $checkoutItem->total_price = (string) $totalValueItem;
                $checkoutItem->update();

                $checkout->partial_value = (string) ($checkout->partial_value + $totalValueItem);
                $checkout->total_value = (string) ($checkout->total_value + $totalValueItem);
                $checkout->update();

                $return['error'] = false;
                $return['message'] = 'Item added to your cart.';
                $return['checkout'] = $checkout;
                return $return;
            }catch(Exception $e){
                Log::error('CheckoutBusiness.addItem: '.$e->getMessage());
                $return['error'] = true;
                $return['message'] = 'It was no possible complete your request. Please try again later...';
                return $return;
            }
        }
    }

    public static function removeItem($id, $user_id)
	{
        $return = CheckoutBusiness::shoppingCart($user_id);
        if($return['error']){
            return $return;
        }else{
            try{
                $checkoutItem = CheckoutItem::find($id);
                $checkout = $return['checkout'];
                $checkout->partial_value = (string) ($checkout->partial_value - $checkoutItem->total_price);
                $checkout->total_value = (string) ($checkout->total_value - $checkoutItem->total_price);
                $checkout->update();
                
                $checkoutItem->delete();

                $return['error'] = false;
                $return['message'] = 'Item removed from your cart.';
                $return['checkout'] = $checkout;
                return $return;
            }catch(Exception $e){
                Log::error('CheckoutBusiness.removeItem: '.$e->getMessage());
                $return['error'] = true;
                $return['message'] = 'It was no possible complete your request. Please try again later...';
                return $return;
            }
        }
    }
    
    public static function plusItem($id, $user_id)
	{
        $return = CheckoutBusiness::shoppingCart($user_id);
        if($return['error']){
            return $return;
        }else{
            try{
                $checkoutItem = CheckoutItem::find($id);
                $checkoutItem->quantity = $checkoutItem->quantity + 1;
                $checkoutItem->total_price = (string) ($checkoutItem->quantity * $checkoutItem->unitary_price);
                $checkoutItem->update();

                $checkout = $return['checkout'];
                $checkout->partial_value = (string) ($checkout->partial_value + $checkoutItem->unitary_price);
                $checkout->total_value = (string) ($checkout->total_value + $checkoutItem->unitary_price);
                $checkout->update();

                $return['error'] = false;
                $return['message'] = 'Item removed from your cart.';
                $return['checkout'] = $checkout;
                return $return;
            }catch(Exception $e){
                Log::error('CheckoutBusiness.plusItem: '.$e->getMessage());
                $return['error'] = true;
                $return['message'] = 'It was no possible complete your request. Please try again later...';
                return $return;
            }
        }
    }

    public static function minusItem($id, $user_id)
	{
        $return = CheckoutBusiness::shoppingCart($user_id);
        if($return['error']){
            return $return;
        }else{
            try{
                $checkoutItem = CheckoutItem::find($id);
                if($checkoutItem->quantity - 1 > 0){
                    $checkoutItem->quantity = $checkoutItem->quantity - 1;
                    $checkoutItem->total_price = (string) ($checkoutItem->quantity * $checkoutItem->unitary_price);
                    $checkoutItem->update();

                    $checkout = $return['checkout'];
                    $checkout->partial_value = (string) ($checkout->partial_value - $checkoutItem->unitary_price);
                    $checkout->total_value = (string) ($checkout->total_value - $checkoutItem->unitary_price);
                    $checkout->update();

                    $return['error'] = false;
                    $return['message'] = 'Item removed from your cart.';
                    $return['checkout'] = $checkout;
                    return $return;
                }else{
                    return CheckoutBusiness::removeItem($id, $user_id);
                }
            }catch(Exception $e){
                Log::error('CheckoutBusiness.minusItem: '.$e->getMessage());
                $return['error'] = true;
                $return['message'] = 'It was no possible complete your request. Please try again later...';
                return $return;
            }
        }
    }  
    
    public static function plusTip($user_id)
	{
        $return = CheckoutBusiness::shoppingCart($user_id);
        if($return['error']){
            return $return;
        }else{
            try{
				$checkout = $return['checkout'];
				$checkout->rider_tip = (string) ($checkout->rider_tip + 1);
				$checkout->total_value = (string) ($checkout->total_value + 1);
                $checkout->update();
                
                $return['error'] = false;
                $return['message'] = 'Your cart was updated.';
                $return['checkout'] = $checkout;
                return $return;
            }catch(Exception $e){
                Log::error('CheckoutBusiness.plusTip: '.$e->getMessage());
                $return['error'] = true;
                $return['message'] = 'It was no possible complete your request. Please try again later...';
                return $return;
            }
        }
    }
    
    public static function minusTip($user_id)
	{
		$return = CheckoutBusiness::shoppingCart($user_id);
        if($return['error']){
            return $return;
        }else{
            try{
                $checkout = $return['checkout'];
				if($checkout->rider_tip > 0){
					$checkout->rider_tip = (string) ($checkout->rider_tip - 1);
					$checkout->total_value = (string) ($checkout->total_value - 1);
                    $checkout->update();
                }

                $return['error'] = false;
                $return['message'] = 'Your cart was updated.';
                $return['checkout'] = $checkout;
                return $return;
            }catch(Exception $e){
                Log::error('CheckoutBusiness.minusTip: '.$e->getMessage());
                $return['error'] = true;
                $return['message'] = 'It was no possible complete your request. Please try again later...';
                return $return;
            }
        }
    }		
}