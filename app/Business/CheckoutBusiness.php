<?php

namespace App\Business;

use Exception;
use GoogleMaps;
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
    
    public static function confirmCheckout($user_id, $shop_id, $deliverOrCollect, $phone, $postcode, $address)
    {
        try{
            $return = CheckoutBusiness::shoppingCart($user_id);
            if($return['error']){
                return $return;
            }else{
                $checkout = $return['checkout'];
                if(!$checkout->checkoutItems->count()){
                    $return['error'] = true;
                    $return['message'] = 'Your cart is empty.';
                    return $return;
                }else{
                    //Shop not selected Error
                    if(!isset($shop_id)){
                        $return['error'] = true;
                        $return['message'] = 'Shop must be selected.';
                        return $return;
                    }else{
                        $shop = Shop::find($shop_id);

                        //Deliver the order
                        if($deliverOrCollect == 'deliver'){
                            if($shop->isOpen()){
                                $return = CheckoutBusiness::validateDistance($shop_id, $phone, $postcode, $address);
                                //Distance Error
                                if($return['error']){
                                    return $return;
                                }else{
                                    //Deliver success.
                                    $checkout->delivery_phone = $phone;
                                    $checkout->delivery_postcode = $postcode;
                                    $checkout->delivery_address = $address;
                                    $checkout->confirmed = true;
                                    $checkout->new_order = true;
                                    $checkout->update();

                                    $return['error'] = false;
                                    $return['message'] = 'Your order will be delivered in 30 minutes.';
                                    return $return;
                                }                                
                            }else{
                                //Deliver Time Error
                                $return['error'] = true;
                                $return['message'] = 'Unfortunately the selected shop is closed now.';
                                return $return;
                            }
                        //Collect the order
                        }else{
                            if($shop->isOpen()){
                                //Collect Success
                                $checkout->confirmed = true;
                                $checkout->new_order = true;
                                $checkout->update();

                                $return['error'] = false;
                                $return['message'] = 'Collect your order in our shop in 30 minutes.';
                                return $return;
                            }else{
                                //Collect Time Error
                                $return['error'] = true;
                                $return['message'] = 'Unfortunately the selected shop is closed now.';
                                return $return;
                            }
                        }
                    }
                }
            }
        }catch(Exception $e){
            Log::error('CheckoutBusiness.confirmCheckout: '.$e->getMessage());
            $return['error'] = true;
            $return['message'] = 'It was no possible complete your request. Please try again later...';
            return $return;
        }
    }

    private static function validateDistance($preferredShop, $phone, $postcode, $address)
    {
        try{
            $msgError = CheckoutBusiness::validateAddress($phone, $postcode, $address);     
            if(strlen($msgError) == 0) {
                $shop = Shop::find($preferredShop);

                $response = GoogleMaps::load('distancematrix')
                    ->setParam (['origins' => str_slug($shop->address, '+')])
                    ->setParam (['destinations' => str_slug($address, '-')])
                    ->setParam (['units' => 'imperial'])
                        ->get();

                //Precisa criar uma conta de faturamento para receber 300 dolares de uso
                $return['error'] = false;
                return $return;

                $details = json_decode($response);

                if(isset($details->rows[0]->elements[0]->distance)){
                    $distance = $details->rows[0]->elements[0]->distance->text;
                    //Too far away to deliver. Distance in miles.
                    if($distance > 5){
                        return false;
                    }else{
                        return true;
                    }
                }else{
                    //No results
                    return false;
                }
            }else{
                $return['error'] = true;
                $return['message'] = $msgError;
                return $return;
            }
        }catch(Exception $e){
            Log::error('CheckoutBusiness.validateDistance: '.$e->getMessage());
            $return['error'] = true;
            $return['message'] = 'It was no possible complete your request. Please try again later...';
            return $return;
        }
    }

    private static function validateAddress($phone, $postcode, $address)
    {
        if(!isset($phone)){
            return "Field 'phone' must be filled.";
        } else if(!isset($postcode)){
            return "Field 'postcode' must be filled.";
        } else if(!isset($address)){
            return "Field 'address' must be filled.";
        }

        return '';
    }
}