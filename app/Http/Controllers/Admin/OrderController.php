<?php

namespace App\Http\Controllers\Admin;

use Auth;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Util\Util;
use App\Checkout;
use App\Shop;

class OrderController extends Controller
{
    public function index($shop_id){
        if(auth()->user()->can('orders_list')){
            $shop = Shop::find($shop_id);

            $registers = Checkout::where('confirmed', '=', true)
                ->where('shop_id', '=', $shop_id)
            	->where('printed', '=', false)
            	->orderBy('updated_at', 'asc')
            	->paginate(5);

            $newOrders = Checkout::where('confirmed', '=', true)
            	->where('printed', '=', false)
            	->where('new_order', '=', true)
            	->get();

            foreach ($newOrders as $order) {
            	$order->new_order = false;
            	$order->update();
            }

            return view('admin.order.index')
                ->with(['shop' => $shop])
                ->with(['registers' => $registers])
                ->with(['hasNewOrder' => $newOrders->count()])
                ->with('previousPage', 'admin.order.shop');
        }else{
           return Util::redirectHome();
        }
    }

    public function shop()
    {
        if(auth()->user()->can('orders_list')){
            $return = Util::listShops(false);
            if($return['error']){
                return view('admin.order.shop')
            		->with(['registers' => null])
                    ->with(['currentMenu' => 'orders'])
                    ->with(['message' => $return['message']])
                    ->with(['typeMessage' => 'red white-text']);
            }else{
                return view('admin.order.shop')
            		->with(['registers' => $return['list']])
                    ->with(['currentMenu' => 'orders']);
            }
        }else{
            return Util::redirectHome();
        }
    }

    public function print($id)
    {
    	if(auth()->user()->can('order_print')){
            $checkout = Checkout::find($id);
            $checkout->printed = true;
            $checkout->update();

            if(isset($checkout->checkout_message)){
                $checkout->checkout_message = Util::splitText($checkout->checkout_message, 40, "\n");
            }
            
            return PDF::loadView('pdf.invoice', compact('checkout'))
        		->stream('download.pdf');
        }else{
           return Util::redirectHome();
        }
    }
}
