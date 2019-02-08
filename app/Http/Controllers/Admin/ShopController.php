<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Util\Util;
use App\Shop;

class ShopController extends Controller
{
    public function index(){
        if(auth()->user()->can('shops_list')){
            $return = Util::listShops(false);
            if($return['error']){
                return view('admin.shop.index')
            		->with(['registers' => null])
                    ->with(['currentMenu' => 'shops'])
                    ->with(['message' => $return['message']])
                    ->with(['typeMessage' => 'red white-text']);
            }else{
                return view('admin.shop.index')
            		->with(['registers' => $return['list']])
                    ->with(['currentMenu' => 'shops']);
            }
        }else{
           return Util::redirectHome();
        }
    }

    public function add()
    {
        if(auth()->user()->can('shop_add')){
            return view('admin.shop.add')
            	->with(['previousPage' => 'admin.shop']);
        }else{
           return Util::redirectHome();
        }
    }

    public function save(Request $request)
    {
        if(auth()->user()->can('shop_add')){
            $data = $request->all();

            $register = new Shop();
            $register->name = $data['name'];
            $register->address = $data['address'];
            $register->available = isset($data['available']) ? true : false;

			$msgError = $this->validateShop($register, $data);
            if(!isset($msgError)){
                $register->save();

                $message = 'Shop created successfully.';
                $typeMessage = 'green white-text';

                return redirect()->route('admin.shop')
                    ->with(['message' => $message])
                    ->with(['typeMessage' => $typeMessage]);
            }else{
            	\Session::flash('register', $register);

                return redirect()->back()
                	->with(['previousPage' => 'admin.shop'])
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
	        $register = Shop::find($id);
	        
	        \Session::flash('register', $register);

            return view('admin.shop.edit')
            	->with(['previousPage' => 'admin.shop']);
        }else{
           return Util::redirectHome();
        }
    }

    public function update(Request $request, $id)
    {
        if(auth()->user()->can('shop_edit')){
        	$data = $request->all();

            $register = Shop::find($id);
            $register->name = $data['name'];
            $register->address = $data['address'];
            $register->available = isset($data['available']) ? true : false;

			$msgError = $this->validateShop($register, $data);
            if(!isset($msgError)){
                $register->update();

                $message = 'Shop updated successfully.';
                $typeMessage = 'green white-text';

                return redirect()->route('admin.shop')
                    ->with(['message' => $message])
                    ->with(['typeMessage' => $typeMessage]);
            }else{
            	\Session::flash('register', $register);

                return redirect()->back()
                	->with(['previousPage' => 'admin.shop'])
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
            Shop::find($id)->delete();

            $message = 'Shop deleted successfully.';
            $typeMessage = 'green white-text';

            return redirect()->route('admin.shop')
                ->with( ['message' => $message] )
                ->with( ['typeMessage' => $typeMessage] );
        }else{
           return Util::redirectHome();
        }
    }

    //If there is not message error, it moves forward
    private function validateShop($register, $data)
    {
        if(!isset($register->name)){
            return 'Fields with * must be filled.';
        }else if(!isset($register->address)){
            return 'Fields with * must be filled.';
        }

        return null;
    }
}
