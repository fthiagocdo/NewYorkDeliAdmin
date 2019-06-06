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
use App\Customer;
use App\MenuItem;
use App\CheckoutItem;
use App\CheckoutItemExtra;
use App\PaymentConfirmation;

class CheckoutBusiness
{
    public static function shoppingCart($customer_id, $shop_id)
	{
        try{
            $shops = Shop::all();
            $checkout = CheckoutBusiness::findOrCreateCheckout($customer_id, $shop_id);
            
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
            $return['message'] = $e->getMessage();
            return $return;
        }
    }
    
    public static function findOrCreateCheckout($customer_id, $shop_id)
	{
        try{
            $checkout = Checkout::where('customer_id', '=', $customer_id)
                ->where('shop_id', '=', $shop_id)
                ->where('confirmed', '=', false)
                ->first();
                
            if(!isset($checkout)){
                $checkout = new Checkout();
                $checkout->customer_id = $customer_id;
                $checkout->partial_value = 0.0;
                $checkout->deliver_or_collect = 'deliver_address';
                $checkout->delivery_fee = 2;
                $checkout->rider_tip = 0.0;
                $checkout->shop_id = $shop_id;
                
                $checkout->save();
            }
            
            //Verify if the shop has delivery. If not, set up checkout details
            if(!$checkout->shop()->delivery){
                $checkout->delivery_fee = 0;
                if($checkout->deliver_or_collect == 'deliver_address'){
                    $checkout->deliver_or_collect = "deliver_table";
                }
            }

            $checkout->total_value = $checkout->partial_value + $checkout->delivery_fee + $checkout->rider_tip;
            
            return $checkout;
        }catch(Exception $e){
            Log::error('CheckoutBusiness.findOrCreateCheckout: '.$e->getMessage());
            $return['error'] = true;
            $return['message'] = 'It was no possible complete your request. Please try again later...';
            return $return;
        }
    }

    public static function deleteShoppingCart($customer_id)
	{
        try{
            $lastCheckout = Checkout::where('customer_id', '=', $customer_id)
                ->where('confirmed', '=', false)
                ->first();

            if(isset($lastCheckout)){
                $lastCheckout->delete();
            }
            
            $return['error'] = false;
            $return['message'] = 'OK';
            return $return;
        }catch(Exception $e){
            Log::error('CheckoutBusiness.deleteShoppingCart: '.$e->getMessage());
            $return['error'] = true;
            $return['message'] = $e->getMessage();
            return $return;
        }
    }
    
    public static function addItem($data, $customer_id, $shop_id)
    {   	
        $return = CheckoutBusiness::shoppingCart($customer_id, $shop_id);
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
                $return['message'] = $e->getMessage();
                return $return;
            }
        }
    }

    public static function removeItem($id, $shop_id, $customer_id)
	{
        $return = CheckoutBusiness::shoppingCart($customer_id, $shop_id);
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
    
    public static function plusItem($id, $shop_id, $customer_id)
	{
        $return = CheckoutBusiness::shoppingCart($customer_id, $shop_id);
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

    public static function minusItem($id, $shop_id, $customer_id)
	{
        $return = CheckoutBusiness::shoppingCart($customer_id, $shop_id);
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
                    return CheckoutBusiness::removeItem($id, $customer_id);
                }
            }catch(Exception $e){
                Log::error('CheckoutBusiness.minusItem: '.$e->getMessage());
                $return['error'] = true;
                $return['message'] = 'It was no possible complete your request. Please try again later...';
                return $return;
            }
        }
    }  
    
    public static function plusTip($customer_id, $shop_id)
	{
        $return = CheckoutBusiness::shoppingCart($customer_id, $shop_id);
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
    
    public static function minusTip($customer_id, $shop_id)
	{
		$return = CheckoutBusiness::shoppingCart($customer_id, $shop_id);
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

    public static function deliverOrCollect($customer_id, $shop_id, $deliverOrCollect)
	{
        $return = CheckoutBusiness::shoppingCart($customer_id, $shop_id);
        if($return['error']){
            return $return;
        }else{
            try{
				$checkout = $return['checkout'];
                $checkout->deliver_or_collect = $deliverOrCollect;
                if($deliverOrCollect == 'deliver_address'){
                    $checkout->delivery_fee = 2;
                    $checkout->total_value = (string) ($checkout->total_value + 2);
                }else{
                    $checkout->delivery_fee = 0;
                    $checkout->total_value = (string) ($checkout->total_value - 2);
                    if($checkout->total_value < 0){
                        $checkout->total_value = "0";
                    }
                }
                $checkout->update();
                
                $return['error'] = false;
                $return['message'] = 'Your cart was updated.';
                $return['checkout'] = $checkout;
                return $return;
            }catch(Exception $e){
                Log::error('CheckoutBusiness.deliverOrCollect: '.$e->getMessage());
                $return['error'] = true;
                $return['message'] = 'It was no possible complete your request. Please try again later...';
                return $return;
            }
        }
    }

    public static function checkoutMessage($customer_id, $shop_id, $checkout_message)
	{
        $return = CheckoutBusiness::shoppingCart($customer_id, $shop_id);
        if($return['error']){
            return $return;
        }else{
            try{
				$checkout = $return['checkout'];
                $checkout->checkout_message = $checkout_message;
                $checkout->update();
                
                $return['error'] = false;
                $return['message'] = 'OK';
                $return['checkout'] = $checkout;
                return $return;
            }catch(Exception $e){
                Log::error('CheckoutBusiness.checkoutMessage: '.$e->getMessage());
                $return['error'] = true;
                $return['message'] = 'It was no possible complete your request. Please try again later...';
                return $return;
            }
        }
    }
    
    public static function confirmCheckout($customer_id, $shop_id, $time, $name, $phone, $postcode, $address, $table_number)
    {
        try{
            $return = CheckoutBusiness::shoppingCart($customer_id, $shop_id);
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
                        $return = CheckoutBusiness::validateTime($time, $shop_id, $checkout->deliver_or_collect);
                        //Time Error
                        if($return['error']){
                            return $return;
                        }else{
                            $time = $return['time'];
                            $shop = Shop::find($shop_id);

                            //Deliver the order at the address
                            if($checkout->deliver_or_collect == 'deliver_address'){
                                if($shop->isOpen()){
                                    /*$return = CheckoutBusiness::validateDistance($shop_id, $phone, $postcode, $address);
                                    //Distance Error
                                    if($return['error']){
                                        return $return;
                                    }else{*/
                                        $msgError = CheckoutBusiness::validateAddress($name, $phone, $postcode, $address);
                                        if(strlen($msgError) != 0) {
                                            //Required field error
                                            $return['error'] = true;
                                            $return['message'] = $msgError;
                                            return $return;
                                        }else{
                                            //Deliver success.
                                            $checkout->delivery_name = $name;
                                            $checkout->delivery_phone = $phone;
                                            $checkout->delivery_postcode = $postcode;
                                            $checkout->delivery_address = $address;
                                            $checkout->time_delivery_collect = $time;
                                            $checkout->update();

                                            $return['error'] = false;
                                            $return['message'] = 'OK';
                                            return $return;
                                        }
                                   // }                              
                                }else{
                                    //Deliver Time Error
                                    $return['error'] = true;
                                    $return['message'] = 'Unfortunately the selected shop is closed now.';
                                    return $return;
                                }
                            //Deliver the order at the table
                            }else if($checkout->deliver_or_collect == 'deliver_table'){
                                if($shop->isOpen()){
                                    $msgError = CheckoutBusiness::validateTable($name, $phone, $table_number);
                                    if(strlen($msgError) != 0) {
                                        //Required field error
                                        $return['error'] = true;
                                        $return['message'] = $msgError;
                                        return $return;
                                    }else{
                                        //Deliver Table Success
                                        $checkout->delivery_name = $name;
                                        $checkout->delivery_phone = $phone;
                                        $checkout->table_number = $table_number;
                                        $checkout->time_delivery_collect = $time;
                                        $checkout->update();

                                        $return['error'] = false;
                                        $return['message'] = 'OK';
                                        return $return;
                                    }
                                }else{
                                    //Collect Time Error
                                    $return['error'] = true;
                                    $return['message'] = 'Unfortunately the selected shop is closed now.';
                                    return $return;
                                }
                            //Collect the order
                            }else{
                                if($shop->isOpen()){
                                    $msgError = CheckoutBusiness::validateCollect($name, $phone);
                                    if(strlen($msgError) != 0) {
                                        //Required field error
                                        $return['error'] = true;
                                        $return['message'] = $msgError;
                                        return $return;
                                    }else{
                                        //Collect Success
                                        $checkout->delivery_name = $name;
                                        $checkout->delivery_phone = $phone;
                                        $checkout->delivery_postcode = $postcode;
                                        $checkout->delivery_address = $address;
                                        $checkout->time_delivery_collect = $time;
                                        $checkout->update();

                                        $return['error'] = false;
                                        $return['message'] = 'OK';
                                        return $return;
                                    }
                                    
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
            }
        }catch(Exception $e){
            Log::error('CheckoutBusiness.confirmCheckout: '.$e->getMessage());
            $return['error'] = true;
            $return['message'] = 'It was no possible complete your request. Please try again later...';
            return $return;
        }
    }

    public static function paymentConfirmation($customer_id, $shop_id, $email, $transactionId, $retrievalReference)
	{
        $return = CheckoutBusiness::shoppingCart($customer_id, $shop_id);
        if($return['error']){
            return $return;
        }else{
            try{
                if(isset($transactionId) && isset($retrievalReference)){
                    $checkout = $return['checkout'];
                    $checkout->confirmed = true;
                    $checkout->new_order = true;
                    $checkout->update();
                    
                    $paymentConfirmation = new PaymentConfirmation();
                    $paymentConfirmation->checkout_id = $checkout->id;
                    $paymentConfirmation->transaction_id = $transactionId;
                    $paymentConfirmation->retrieval_reference = $retrievalReference;
                    $paymentConfirmation->order_number = $checkout->customer_id.$checkout->id;
                    $paymentConfirmation->save();

                    CheckoutBusiness::sendInvoice($checkout, $email);

                    if($checkout->deliver_or_collect == 'deliver_address'){
                        $return['error'] = false;
                        $return['message'] = 'Please, make a note of your order number: '.$paymentConfirmation->order_number.'. Your order will be delivered at '.$checkout->time_delivery_collect.' at your address.';
                        return $return;
                    }else if($checkout->deliver_or_collect == 'deliver_table'){
                        $return['error'] = false;
                        $return['message'] = 'Please, make a note of your order number: '.$paymentConfirmation->order_number.'. Your order will be delivered in 15 minutes or less at your table.';
                        return $return;
                    }else{
                        $return['error'] = false;
                        $return['message'] = 'Please, make a note of your order number: '.$paymentConfirmation->order_number.'.  You can collect your order in our shop at '.$checkout->time_delivery_collect.'.';
                        return $return;
                    }
                }else{
                    $return['error'] = true;
                    $return['message'] = 'It was no possible complete your request. Please try again later...';
                    return $return;
                }
            }catch(Exception $e){
                Log::error('CheckoutBusiness.paymentConfirmation: '.$e->getMessage());
                $return['error'] = true;
                $return['message'] = $e->getMessage();
                return $return;
            }
        }
    }

    private static function sendInvoice($checkout, $email)
    {
        try{
            $customer = $checkout->customer()->first();
            $payment = $checkout->payment()->first();
            $pdf_path = 'public/receipts/'.$customer->id.'/'.$payment->order_number.'.pdf';

            if(isset($checkout->checkout_message)){
                $checkout->checkout_message = Util::splitText($checkout->checkout_message, 40, "\n");
            }
            
            return Util::sendMailInvoice($customer->name, $email, PDF::loadView('pdf.invoice', compact('checkout'))->output(), 'invoice.pdf');
        }catch(Exception $e){
            Log::error('CheckoutBusiness.sendInvoice: '.$e->getMessage());
            $return['error'] = true;
            $return['message'] = $e->getMessage();
            return $return;
        }
    }

    public static function getLimitTimeOrder($shop_id)
	{
        try{
            $shopSchedule = ShopSchedule::where('shop_id', '=', $shop_id)
                ->where('day_week', '=', Carbon::now()->format('l'))
                ->first();
        
            $hourInitial = (int) Carbon::now()->format('H');
            $hourFinal = (int) substr($shopSchedule->closing_time, 0, strpos($shopSchedule->closing_time, ':'));
            
            $hourValues[0] = $hourInitial;
            for($i = 1; $hourInitial < $hourFinal; $i++){
                $hourValues[$i] = ++$hourInitial;
            }

            $minuteValues[0] = $minuteInitial = 0;
            for($i = 1; $minuteInitial < 45; $i++){
                $minuteValues[$i] = $minuteInitial = $minuteInitial + 15;
            }

            $return['error'] = false;
            $return['message'] = 'OK';
            $return['hourValues'] = $hourValues;
            $return['minuteValues'] = $minuteValues;
            return $return;
        }catch(Exception $e){
            Log::error('CheckoutBusiness.getLimitTimeOrder: '.$e->getMessage());
            $return['error'] = true;
            $return['message'] = 'It was no possible complete your request. Please try again later...';
            return $return;
        }
    }

    private static function validateTime($time, $shop_id, $delivery_or_collect)
    {
        try{
            //Deliver table does not have time
            if($delivery_or_collect == 'deliver_table'){
                $return['error'] = false;
                $return['message'] = "OK";
                $return['time'] = Carbon::now()->addMinutes(15)->format('H:i');
                return $return;
            }else{
                //For delivery address, minimun time is 30 minutes
                if($delivery_or_collect == 'deliver_address'){
                    $minimun_time = 30;
                //For collect, minimun time is 15 minutes
                }else{
                    $minimun_time = 15;
                }
                
                if(!isset($time)){
                    $return['error'] = false;
                    $return['message'] = "OK";
                    $return['time'] = Carbon::now()->addMinutes($minimun_time)->format('H:i');
                    return $return;
                }else{
                    $now = Carbon::now();
                    $hour = (int) substr($time, 0, strpos($time, ':'));
                    $minute = (int) substr($time, strpos($time, ':')+1);
                    $time = Carbon::createFromTime($hour, $minute, null, 'Europe/London');
                    //Data Invalid Error
                    if($hour > 24 || $minute > 59){
                        $return['error'] = true;
                        $return['message'] = "Time not valid";
                        return $return;
                    }else{
                        $shopSchedule = ShopSchedule::where('shop_id', '=', $shop_id)
                            ->where('day_week', '=', Carbon::now()->format('l'))
                            ->first();
                    
                        $hourClosing = (int) substr($shopSchedule->closing_time, 0, strpos($shopSchedule->closing_time, ':'));
                        $minuteClosing = (int) substr($shopSchedule->closing_time, strpos($shopSchedule->closing_time, ':')+1);
                        $timeClosing = Carbon::createFromTime($hourClosing, $minuteClosing, null, 'Europe/London');

                        //Shop Closed Error
                        if($time->diffInMinutes($timeClosing, false) <= 0){
                            $return['error'] = true;
                            $return['message'] = 'Sorry, but our shop will be closed at this time. Please inform a new time to delivery or collect.';
                            return $return;
                        //Time must respect minimum time
                        }else if($now->diffInMinutes($time, false) < $minimun_time - 1){
                            $return['error'] = true;
                            $return['message'] = 'Sorry, but we need at least '.$minimun_time.' minutes to prepare your order. Please inform a new time to delivery or collect.';
                            return $return;
                        //Valid Time
                        }else{
                            $return['error'] = false;
                            $return['message'] = "OK";
                            $return['time'] = $time->format('H:i');
                            return $return;
                        }
                    }
                }
            }
        }catch(Exception $e){
            Log::error('CheckoutBusiness.validateTime: '.$e->getMessage());
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

    private static function validateAddress($name, $phone, $postcode, $address)
    {
        if(!isset($name)){
            return "Field 'name' must be filled.";
        } else if(!isset($phone)){
            return "Field 'phone' must be filled.";
        } else if(!isset($postcode)){
            return "Field 'postcode' must be filled.";
        } else if(!isset($address)){
            return "Field 'address' must be filled.";
        }

        return '';
    }

    private static function validateTable($name, $phone, $table_number)
    {
        if(!isset($name)){
            return "Field 'name' must be filled.";
        } else if(!isset($table_number)){
            return "Field 'table number' must be filled.";
        } else if(!isset($phone)){
            return "Field 'phone' must be filled.";
        } 

        return '';
    }

    private static function validateCollect($name, $phone)
    {
        if(!isset($name)){
            return "Field 'name' must be filled.";
        } else if(!isset($phone)){
            return "Field 'phone' must be filled.";
        }

        return '';
    }
}