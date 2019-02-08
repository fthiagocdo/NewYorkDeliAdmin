<?php

namespace App\Http\Controllers\Admin;

use Auth;
use PDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Util\Util;
use App\Checkout;

class OrderController extends Controller
{
    public function index(){
        if(auth()->user()->can('orders_list')){
            $registers = Checkout::where('confirmed', '=', true)
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
            		->with(['registers' => $registers])
            		->with(['hasNewOrder' => $newOrders->count()])
                    ->with(['currentMenu' => 'orders']);
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

	    	$timeDeliveryCollect = Util::createDateFromDatabase($checkout->updated_at)->addMinutes(30);
	    	$stringDate = Util::formatDate($timeDeliveryCollect);

	        return PDF::loadView('pdf.invoice', compact('checkout', 'stringDate'))
        		->stream('download.pdf');
        }else{
           return Util::redirectHome();
        }
    }
}
