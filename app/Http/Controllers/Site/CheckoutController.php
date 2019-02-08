<?php

namespace App\Http\Controllers\Site;

use Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Business\CheckoutBusiness;
use App\Http\Controllers\Controller;
use App\Util\Util;
use App\Checkout;
use App\CheckoutItem;
use App\CheckoutItemExtra;
use App\MenuItem;
use App\MenuExtra;
use App\Shop;
use App\ShopSchedule;
use App\User;

class CheckoutController extends Controller
{
	public function shoppingCart()
	{
		if(Auth::guest()){
			return redirect()->back()
				->with('message', 'Log in to proceed to checkout.')
				->with('typeMessage', 'red white-text');
		}else{
			$shops = Shop::all();

			$return = CheckoutBusiness::shoppingCart(auth()->user()->id);
			$checkout = $return['checkout'];

			return view('site.checkout.shoppingcart')
					->with('checkoutItems',$checkout->checkoutItems)
					->with('checkout', $checkout)
					->with('shops', $shops)
					->with('currentMenu', 'checkout');
		}
	}

    public function addItem(Request $request)
    {
    	if(Auth::guest()){
			return redirect()->back()
                ->with(['message' => 'Log in to add this item to your cart.'])
                ->with(['typeMessage' => 'red white-text']);
		}else{
			$data = $request->all();
			$return = CheckoutBusiness::addItem($data, auth()->user()->id);

	    	if($return['error']){
				return redirect()->back()
					->with('message', $return['message'])
					->with('typeMessage', 'red white-text');
			}else{
				$data = $request->all();
				$menuItem = MenuItem::find($data['menuitem_id']);
				$message = 'Item added to your cart.';
				$typeMessage = 'green white-text';

				return redirect()->route('site.home')
					->with(['message' => $message])
					->with(['typeMessage' => $typeMessage])
					->with(['active_tab' => str_slug($menuItem->type->name, '-')]);
			}
		}
	}
	
	public function removeItem($id)
    {
		if(Auth::guest()){
			return redirect()->back()
				->with(['message' => 'Log in to remove this item from your cart.'])
				->with(['typeMessage' => 'red white-text']);
		}else{
			$return = CheckoutBusiness::removeItem($id, auth()->user()->id);
			if($return['error']){
				return redirect()->back()
					->with('message', $return['message'])
					->with('typeMessage', 'red white-text');
			}else{
				return redirect()->route('site.checkout.shoppingcart')
					->with('message', $return['message'])
					->with('typeMessage', 'green white-text');
			}
		}
	}

	public function plusItem($id)
	{
		if(Auth::guest()){
			return redirect()->back()
				->with(['message' => 'Log in to update this item in your cart.'])
				->with(['typeMessage' => 'red white-text']);
		}else{
			$return = CheckoutBusiness::plusItem($id, auth()->user()->id);
			if($return['error']){
				return redirect()->back()
					->with('message', $return['message'])
					->with('typeMessage', 'red white-text');
			}else{
				return redirect()->route('site.checkout.shoppingcart')
					->with('message', $return['message'])
					->with('typeMessage', 'green white-text');
			}
		}
	}

	public function minusItem($id)
	{
		if(Auth::guest()){
			return redirect()->back()
				->with(['message' => 'Log in to update this item in your cart.'])
				->with(['typeMessage' => 'red white-text']);
		}else{
			$return = CheckoutBusiness::minusItem($id, auth()->user()->id);
			if($return['error']){
				return redirect()->back()
					->with('message', $return['message'])
					->with('typeMessage', 'red white-text');
			}else{
				return redirect()->route('site.checkout.shoppingcart')
					->with('message', $return['message'])
					->with('typeMessage', 'green white-text');
			}
		}
	}

	public function plusTip()
	{
		if(Auth::guest()){
			return redirect()->back()
				->with(['message' => 'Log in to update your cart.'])
				->with(['typeMessage' => 'red white-text']);
		}else{
			$return = CheckoutBusiness::plusTip(auth()->user()->id);
			return redirect()->route('site.checkout.shoppingcart')
				->with('message', $return['message'])
				->with('typeMessage', 'green white-text');
		}
	}

	public function minusTip()
	{
		if(Auth::guest()){
			return redirect()->back()
				->with(['message' => 'Log in to update your cart.'])
				->with(['typeMessage' => 'red white-text']);
		}else{
			$return = CheckoutBusiness::minusTip(auth()->user()->id);
			return redirect()->route('site.checkout.shoppingcart')
				->with('message', $return['message'])
				->with('typeMessage', 'green white-text');
		}
	}

	public function confirm(Request $request)
    {
    	if(Auth::guest()){
			return redirect()->back()
                ->with(['message' => 'Log in to add this item to your cart.'])
                ->with(['typeMessage' => 'red white-text']);
		}else{
			$preferredShop = $request['preferredShop'];
			$deliverOrCollect = $request['deliverOrCollect'];

			if($deliverOrCollect == 'deliver'){
				return redirect()->route('site.checkout.address', $preferredShop);
			}else{
				$return = CheckoutBusiness::confirmCheckout(auth()->user()->id, $preferredShop, 'collect', null, null, null);
				if($return['error']){
					return redirect()->back()
		                ->with(['message' => $return['message']])
		                ->with(['typeMessage' => 'green white-text'])
		                ->with(['previousPage' => 'site.checkout.shoppingcart']);
				}else{
					return redirect()->route('site.home')
						->with(['message' => $return['message']])
						->with(['typeMessage' => 'green white-text'])
						->with(['currentMenu' => 'home']);
				}
			}
		}
    }

    public function address($preferredShop)
    {
		$register = auth()->user();

		return view('site.checkout.address')
			->with(['phone_number' => $register->phone_number])
			->with(['postcode' => $register->postcode])
			->with(['address' => $register->address])
			->with(['preferredShop' => $preferredShop])
			->with(['previousPage' => 'site.checkout.shoppingcart']);
    }

    public function confirmAddress(Request $request)
    {
		if(Auth::guest()){
			return redirect()->back()
				->with(['message' => 'Log in to proceed.'])
				->with(['typeMessage' => 'red white-text']);
		}else{
			$phone = $request['phone_number'];
			$postcode = $request['postcode'];
			$address = $request['address'];
			$preferredShop = $request['preferredShop'];

			$return = CheckoutBusiness::confirmCheckout(auth()->user()->id, $preferredShop, 'deliver', $phone, $postcode, $address);
			if($return['error']){
				return redirect()->back()
					->with(['message' => $return['message']])
					->with(['typeMessage' => 'red white-text'])
					->with(['previousPage' => 'site.checkout.shoppingcart']);
			}else{
				return redirect()->route('site.home')
					->with(['message' => $return['message']])
					->with(['typeMessage' => 'green white-text'])
					->with(['currentMenu' => 'home']);
			}
		}
    }
}
