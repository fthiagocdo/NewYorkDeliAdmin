<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Util\Util;
use App\ShopSchedule;
use App\Shop;

class ShopScheduleController extends Controller
{
    public function index($shop_id){
        if(auth()->user()->can('shops_list')){
        	$shop = Shop::find($shop_id);

            $registers = $shop->shopSchedules()->orderBy('order', 'asc')->get();

            return view('admin.shopschedule.index')
            		->with(['registers' => $registers])
            		->with(['shop' => $shop])
                    ->with(['previousPage' => 'admin.shop']);
        }else{
           return Util::redirectHome();
        }
    }

    public function add($shop_id)
    {
        if(auth()->user()->can('shop_add')){
            return view('admin.shopschedule.add')
            	->with(['shop_id' => $shop_id])
            	->with(['previousPage' => 'admin.shop.shopschedule'])
            	->with(['parameterPreviousPage' => $shop_id]);
        }else{
           return Util::redirectHome();
        }
    }

    public function save(Request $request, $shop_id)
    {
        if(auth()->user()->can('shop_add')){
            $data = $request->all();

            $day_week = collect(['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday']);

            $register = new ShopSchedule();
            $register->day_week = $data['day_week'];
            $register->opening_time = $data['opening_time'];
            $register->closing_time = $data['closing_time'];
            $register->shop_id = $shop_id;
            $register->order = $day_week->search($data['day_week'])+1;
            
			$msgError = $this->validateShopSchedule($register, $data);
            if(!isset($msgError)){
            	ShopSchedule::where('day_week', '=', strtolower($data['day_week']))
                                ->where('shop_id', '=', $shop_id)
                                ->delete();
                $register->save();

                $message = 'Shop schedule created successfully.';
                $typeMessage = 'green white-text';

                return redirect()->route('admin.shop.shopschedule', $shop_id)
                    ->with(['message' => $message])
                    ->with(['typeMessage' => $typeMessage]);
            }else{
            	\Session::flash('register', $register);

                return redirect()->back()
                	->with(['previousPage' => 'admin.shop.shopschedule'])
                	->with(['parameterPreviousPage' => $shop_id])
                    ->with(['message' => $msgError])
                    ->with(['typeMessage' => 'red white-text']);
            }
        }else{
           return Util::redirectHome();
        }
    }

    public function edit($id)
    {
        if(auth()->user()->can('shop_edit')){
	        $register = ShopSchedule::find($id);
	        
	        \Session::flash('register', $register);

            return view('admin.shopschedule.edit')
            	->with(['previousPage' => 'admin.shop.shopschedule'])
                ->with(['parameterPreviousPage' => $register->shop->id]);
        }else{
           return Util::redirectHome();
        }
    }

    public function update(Request $request, $id)
    {
        if(auth()->user()->can('shop_edit')){
            $data = $request->all();

            $day_week = collect(['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday']);

            $register = ShopSchedule::find($id);
            $register->day_week = $data['day_week'];
            $register->opening_time = $data['opening_time'];
            $register->closing_time = $data['closing_time'];
            $register->order = $day_week->search($data['day_week'])+1;
            
			$msgError = $this->validateShopSchedule($register, $data);
            if(!isset($msgError)){
            	ShopSchedule::where('day_week', '=', strtolower($data['day_week']))
            					->where('id', '<>', $register->id)
                                ->where('shop_id', '=', $register->shop->id)
            					->delete();
                $register->update();

                $message = 'Shop schedule updated successfully.';
                $typeMessage = 'green white-text';

                return redirect()->route('admin.shop.shopschedule', $register->shop->id)
                    ->with(['message' => $message])
                    ->with(['typeMessage' => $typeMessage]);
            }else{
            	\Session::flash('register', $register);

                return redirect()->back()
                	->with(['previousPage' => 'admin.shop.shopschedule'])
                	->with(['parameterPreviousPage' => $register->shop->id])
                    ->with(['message' => $msgError])
                    ->with(['typeMessage' => 'red white-text']);
            }
        }else{
           return Util::redirectHome();
        }
    }

    public function delete($id)
    {
        if(auth()->user()->can('shop_delete')){
        	$shop_id = ShopSchedule::find($id)->shop->id;
            ShopSchedule::find($id)->delete();

            $message = 'Shop schedule deleted successfully.';
            $typeMessage = 'green white-text';

            return redirect()->route('admin.shop.shopschedule', $shop_id)
                ->with( ['message' => $message] )
                ->with( ['typeMessage' => $typeMessage] );
        }else{
           return Util::redirectHome();
        }
    }

    //If there is not message error, it moves forward
    private function validateShopSchedule($register, $data)
    {
        if(!isset($register->opening_time)){
            return 'Fields with * must be filled.';
        }else if(!isset($register->closing_time)){
            return 'Fields with * must be filled.';
        }else{
        	$hourOpening = (int) substr($data['opening_time'], 0, strpos($data['opening_time'], ':'));
            $minuteOpening = (int) substr($data['opening_time'], strpos($data['opening_time'], ':')+1);
            $timeOpening = Carbon::createFromTime($hourOpening, $minuteOpening, null, 'Europe/London');
            $hourClosing = (int) substr($data['closing_time'], 0, strpos($data['closing_time'], ':'));
            $minuteClosing = (int) substr($data['closing_time'], strpos($data['closing_time'], ':')+1);
            $timeClosing = Carbon::createFromTime($hourClosing, $minuteClosing, null, 'Europe/London');
            if($hourOpening > 24 || $hourClosing > 24){
            	return 'Ending and closing times not valids';
            }else if($minuteOpening > 59 || $minuteClosing > 59){
            	return 'Ending and closing times not valids';
            }else if($hourOpening > $hourClosing){
            	return 'Ending and closing times not valids';
            }else if($hourOpening == $hourClosing && $minuteOpening >= $minuteClosing){
            	return 'Ending and closing times not valids';
            }else if($timeOpening->diffInMinutes($timeClosing, false) <= 0){
	        	return 'Ending and closing times not valids';
	        }
        }

        return null;
    }
}
