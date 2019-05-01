<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Checkout;
use App\CheckoutItem;
use App\CheckoutItemExtra;

class OrderHistoryController extends Controller
{
    public function index($user_id, $shop_id)
    {
		try{
			$registers = Checkout::where('user_id', '=', $user_id)
				->where('shop_id', '=', $shop_id)
				->where('confirmed', '=', true)
				->orderBy('updated_at', 'desc')
				->get();

			$return['error'] = false;
            $return['list'] = $registers;
            return $return;
        }catch(Exception $e){
            Log::error('OrderHistoryController.index: '.$e->getMessage());
            $return['error'] = true;
            $return['message'] = 'It was no possible complete your request. Please try again later...';
            return $return;
        }
    }

    public function details($id, $mode = null)
	{
		$register = Checkout::find($id);
		
		if($mode == 'api'){
			$order = array();
			$order['id'] = $register->id;
			$order['partialValue'] = $register->partial_value;
			$order['deliveryFee'] = $register->delivery_fee;
			$order['riderTip'] = $register->rider_tip;
			$order['totalValue'] = $register->total_value;

			//order -> checkoutItem -> checkoutItemExtra
			$listcheckoutItem = array();
			foreach ($register->checkoutItems as $checkoutItem) {
				$itemMenu = array();
				$itemMenu['name'] = $checkoutItem->menuItem->name;
				$itemMenu['price'] = $checkoutItem->unitary_price;
				$itemMenu['type'] = $checkoutItem->menuItem->type->name;
				$itemMenu['quantity'] = $checkoutItem->quantity;
				$itemMenu['totalValue'] = $checkoutItem->total_price;

				$listcheckoutItemExtra = array();
				foreach ($checkoutItem->checkoutItemExtras as $checkoutItemExtra) {
					$itemExtra = array();
					$itemExtra['name'] = $checkoutItemExtra->menuExtra->name;
					$itemExtra['price'] = $checkoutItemExtra->menuExtra->price;

					$listcheckoutItemExtra[] = $itemExtra;
				}
				$itemMenu['checkoutItemExtras'] = $listcheckoutItemExtra;
				$listcheckoutItem[] = $itemMenu;
			}
			
			$order['checkoutItems'] = $listcheckoutItem;
			
            if(isset($register)){
                return response()->json($order);
            }else{
                return response()->json([
                    'messsage' => 'Register not found.',
                    'status' => 'ERROR'
                ], 404);
            }
       }else{
			return view('admin.orderhistory.details')
					->with(['checkoutItems' => $register->checkoutItems])
					->with(['checkout' => $register])
					->with(['previousPage' => 'admin.orderhistory']);
		}
	}

	public function orderAgain($id)
	{
		//Find and delete the last stil not confirmed checkout
		$lastCheckout = Checkout::where('user_id', '=', auth()->user()->id)
			->where('confirmed', '=', false)
			->first();

		if(isset($lastCheckout)){
			$lastCheckout->delete();
		}

		//Clone the selected checkout
		$checkout = Checkout::find($id);
		
		$newCheckout = new Checkout();
		$newCheckout->user_id = $checkout->user_id;
		$newCheckout->shop_id = $checkout->shop_id;
		$newCheckout->partial_value = $checkout->partial_value;
		$newCheckout->delivery_fee = $checkout->delivery_fee;
		$newCheckout->rider_tip = $checkout->rider_tip;
		$newCheckout->total_value = $checkout->total_value;
		$newCheckout->delivery_postcode = $checkout->delivery_postcode;
		$newCheckout->delivery_postcode = $checkout->delivery_postcode;
		$newCheckout->delivery_address = $checkout->delivery_address;
		$newCheckout->delivery_address = $checkout->delivery_address;
		$newCheckout->delivery_phone = $checkout->delivery_phone;
		$newCheckout->save();

		foreach ($checkout->checkoutItems as $checkoutItem) {
			$newCheckoutItem = new CheckoutItem();
			$newCheckoutItem->checkout_id = $newCheckout->id;
			$newCheckoutItem->unitary_price = $checkoutItem->unitary_price;
			$newCheckoutItem->quantity = $checkoutItem->quantity;
			$newCheckoutItem->total_price = $checkoutItem->total_price;
			$newCheckoutItem->total_price = $checkoutItem->total_price;
			$newCheckoutItem->menuitem_id = $checkoutItem->menuitem_id;
			$newCheckoutItem->save();

			foreach ($checkoutItem->checkoutItemExtras as $checkoutItemExtra) {
				$newCheckoutItemExtra = new CheckoutItemExtra();
				$newCheckoutItemExtra->checkoutitem_id = $newCheckoutItem->id;
				$newCheckoutItemExtra->price = $checkoutItemExtra->price;
				$newCheckoutItemExtra->menuextra_id = $checkoutItemExtra->menuextra_id;
				$newCheckoutItemExtra->save();
			}
		}

		return redirect()->route('site.checkout.shoppingcart');
	}
}
