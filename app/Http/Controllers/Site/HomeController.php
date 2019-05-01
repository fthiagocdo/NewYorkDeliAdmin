<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Business\MenuBusiness;
use App\Business\UserBusiness;
use App\Http\Controllers\Controller;
use App\Util\Util;
use App\User;
use App\MenuType;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $shops = Util::listShops(false);
        $data = $request->all();
        if(isset($data['shop_id'])){
            $shop_id = $data['shop_id'];
        }else{
            $shop_id = $shops['list'][0]->id;
        }
        $return = MenuBusiness::findMenuTypes($shop_id);

        return view('site.home')
            ->with('shops', $shops['list'])
            ->with('shop_id', $shop_id)
            ->with('menutypes', $return['list'])
    		->with('currentMenu', 'home');
    }

    public function contactUs()
    {
    	return view('site.contactus')
    		->with('currentMenu', 'contactus');
    }

    public function sendMessage(Request $request)
    {
        $data = $request->all();
        $return = Util::sendMail($data);

        if($return['error']){
            return redirect()->back()
                ->with('name', $data['name'])
                ->with('email', $data['email'])
                ->with('msgEmail', $data['message'])
                ->with('message', $return['message'])
                ->with('typeMessage', 'red white-text');
        }else{
            return redirect()->route('site.contactus')
                ->with('message', $return['message'])
                ->with('typeMessage', 'green white-text');
        }
    }

    public function getAvatar($id)
    {
        $user = User::find($id);

        return UserBusiness::getAvatar($user);
    }
}
