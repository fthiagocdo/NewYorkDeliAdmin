<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth; 
use App\Business\MenuBusiness;
use App\Business\CheckoutBusiness;
use App\Business\OrderBusiness;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\MenuExtraController;
use App\Http\Controllers\Admin\MenuItemController;
use App\Http\Controllers\Admin\MenuTypeController;
use App\Http\Controllers\Admin\OrderHistoryController;
use App\Http\Controllers\Site\CheckoutController;
use App\Http\Controllers\Admin\ShopController;
use App\Util\Util;
use App\User;
use App\Shop;
use App\Checkout;
use App\CheckoutItem;
use App\CheckoutItemExtra;

class ApiController extends Controller
{
    /*public function login(){
        if(Auth::attempt(['email' => request('email'), 'password' => request('uid')])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')-> accessToken; 
            return response()->json(['success' => $success], 200); 
        }else{ 
            return response()->json(['error'=>'Unauthorised'], 401); 
        } 
    }

    public function findUser(){ 
        $user = Auth::user(); 
        return response()->json(['success' => $user], 200); 
    } */

    public function findOrCreateUser(Request $request)
    {
        $name = str_replace("%20", " ", $request['name']);
        $email = str_replace("%20", " ", $request['email']);
        $phone_number = str_replace("%20", " ", $request['phoneNumber']);
        $avatar = str_replace("%20", " ", $request['avatar']);
        $uid = str_replace("%20", " ", $request['uid']);
        $password = str_replace("%20", " ", $request['password']);
        $provider = str_replace("%20", " ", $request['provider']);

        /* Get Token */
        if(Auth::attempt(['email' => $email, 'password' => $uid])){ 
            $user = Auth::user(); 
            $token =  $user->createToken('MyApp')-> accessToken;  
            return response()->json([
                'user' => $user,
                'token' => $token,
                'error' => false
            ], 200);
        }else{
            $valid = true;
            $message = '';
            if($email == null || $email == ''){
                $valid = false;
                $message = "Field 'e-mail' must be filled.";
            }else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $valid = false;
                $message = "E-mail not valid.";
            }else if(($password != null && $password != '') && strlen($password) < 8){
                $valid = false;
                $message = 'Password must be at least 8 characters long.';
            }else if($provider == null || $provider == ''){
                $valid = false;
                $message = "Field 'provider' must be filled.";
            }

            if($valid){
                $user = new User();
                $user->name = $name == null || $name == '' ? substr($user->name, 0, strpos($user->name, '@')) : $name;
                $user->email = $email;
                $user->phone_number = $phone_number;
                if($avatar == null || $avatar == ''){
                    $user->avatar = url('img/user-avatar.png');
                }else{
                    $user->avatar = $avatar;
                }
                /*Password == Firebase UID*/
                $user->password = bcrypt($uid);
                $user->shop_id = Shop::all()->first()->id;
                $user->provider = $provider;
                $user->save();

                $user->addRole('customer');

                return response()->json([
                    'user' => $user,
                    'error' => false
                ], 200);
            }else{
                return response()->json([
                    'error' => true,
                    'message' => $message
                ], 200);
            }
        }
    }

    public function updateUser(Request $request, $id)
    {
        $name = str_replace("%20", " ", $request['name']);
        $email = str_replace("%20", " ", $request['email']);
        $phone_number = str_replace("%20", " ", $request['phoneNumber']);
        $avatar = str_replace("%20", " ", $request['avatar']);
        //$password = str_replace("%20", " ", $request['password']);
        $postcode = str_replace("%20", " ", $request['postcode']);
        $address = str_replace("%20", " ", $request['address']);
        $shop_id = str_replace("%20", " ", $request['preferredShopId']);
        $receive_notifications = str_replace("%20", " ", $request['receiveNotifications']);
        
        $valid = true;
        $message = '';
        if( $name == null || $name == ''){
            $valid = false;
            $message = "Field 'name' must be filled.";
        /*} if( $avatar == null || $avatar == ''){
            $valid = false;
            $message = "Field 'avatar' must be filled.";*/
        /*} else if(($password != null && $password != '') && strlen($password) < 8){
            $valid = false;
            $message = 'Password must be at least 8 characters long.';*/
        } else if($phone_number == null || $phone_number == ''){
            $valid = false;
            $message = "Field 'phone number' must be filled.";
        } else if($postcode == null || $postcode == ''){
            $valid = false;
            $message = "Field 'postcode' must be filled.";
        } else if($address == null || $address == ''){
            $valid = false;
            $message = "Field 'address' must be filled.";
        } else if($shop_id == null || $shop_id == ''){
            $valid = false;
            $message = "Field 'preferred shop' must be filled.";
        } else if($receive_notifications == null || $receive_notifications == ''){
            $valid = false;
            $message = "Field 'receive notifications' must be filled.";
        } 

        if($valid){
            $user = User::find($id);
            $user->name = $name;
            $user->email = $email;
            $user->phone_number = $phone_number;
            $user->avatar = $avatar;
            //$user->password = bcrypt($password);
            $user->postcode = $postcode;
            $user->address = $address;
            $user->shop_id = $shop_id;
            $user->receive_notifications = $receive_notifications;
            $user->update();

            return response()->json([
                'user' => $user, 
                'error' => false,
                'message' => 'User updated successfully.'
            ], 200);
        }else{
            return response()->json([
                'error' => true,
                'message' => $message
            ], 200);
        }
    }

    public function getUser($email)
    {   
        $user = User::where('email', '=', $email)->first();

        if(isset($user)){
            return response()->json([
                'error' => false,
                'user' => $user
            ], 200);
        }else{
            return response()->json([
                'error' => true,
                'message' => 'There is no user related to this e-mail.'
            ], 200);
        }
    }

    public function deleteUser($id)
    {   
        $user = User::find($id);
        if(isset($user)){
            $user->delete();
        }
        return response()->json([
            'error' => false,
            'message' => 'User deleted.'
        ], 200);
    }

    public function uploadImageUser(Request $request, $id)
    {
        $photoName = 'avatar.jpeg';
        $user = User::find($id);
        
        $path = $request->photo->storeAs('/public/avatars/'.$id, $photoName);

        $user->avatar = $photoName;
        $user->update();
        
        return response()->json($photoName, 200);
    }

    public function getImageUser($id)
    {
        $user = User::find($id);
        $path = storage_path('app/public/avatars/'.$id.'/'.$user->avatar);
        
        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }

    public function listMenuExtra($menuitem_id)
    {
        return MenuBusiness::findMenuExtra($menuitem_id);
    }

    public function findMenuExtra($id)
    {   
        return (new MenuExtraController())->find($id, 'api');
    }

    public function listMenuItem($menutype_id)
    {
        return MenuBusiness::findMenuItem($menutype_id);
    }

    public function getMenuItemImage($id)
    {
        return MenuBusiness::getMenuItemImage($id);
    }

    public function listMenuType($preferredShop_id)
    {
        return MenuBusiness::findMenuTypes($preferredShop_id);
    }

    public function findMenuType($id)
    {
        return (new MenuTypeController())->find($id, 'api');
    }

    public function listOrderHistory($user_id, $shop_id)
    {
        return OrderBusiness::listOrderHistory($user_id, $shop_id);
    }

    public function findOrderHistory($id)
    {   
        return OrderBusiness::getOrderDetails($id);
    }

    public function orderAgain($id, $user_id)
	{
		return OrderBusiness::orderAgain($id, $user_id);
	}

    public function getOrderItems($id)
    {   
        return (new OrderHistoryController())->getOrderItems($id, 'api');
    }

    public function getShoppingCart($user_id, $shop_id)
    {
        return CheckoutBusiness::shoppingCart($user_id, $shop_id);
    }

    public function addItemToShoppingCart(Request $request, $user_id, $shop_id)
    {
        $data = $request->all();
        $menuExtras = explode(',', $data['menuExtras']);
        foreach($menuExtras as $menuextra_id){
            $data['menuextra_'.$menuextra_id] = $menuextra_id;
        }
        return CheckoutBusiness::addItem($data, $user_id, $shop_id);
    }

    public function removeItemFromShoppingCart($user_id, $checkoutitem_id)
    {
        return CheckoutBusiness::removeItem($checkoutitem_id, $user_id);
    }

    public function plusItemToShoppingCart($user_id, $checkoutitem_id)
    {
        return CheckoutBusiness::plusItem($checkoutitem_id, $user_id);
    }

    public function minusItemFromShoppingCart($user_id, $checkoutitem_id)
    {
        return CheckoutBusiness::minusItem($checkoutitem_id, $user_id);
    }

    public function plusRiderTip($user_id)
    {
        return CheckoutBusiness::plusTip($user_id);
    }

    public function minusRiderTip($user_id)
    {
        return CheckoutBusiness::minusTip($user_id);
    }

    public function deliverOrCollect(Request $request, $user_id)
    {
        if($request['deliverOrCollect'] == 'null'  || $request['deliverOrCollect'] == ''){
            $deliverOrCollect = 'deliver_address';
        }else{
            $deliverOrCollect = $request['deliverOrCollect'];
        }
        return CheckoutBusiness::deliverOrCollect($user_id, $deliverOrCollect);
    }

    public function checkoutMessage(Request $request, $user_id)
    {
        if($request['checkoutMessage'] == 'null' || $request['checkoutMessage'] == ''){
            $checkout_message = null;
        }else{
            $checkout_message = str_replace("%20", " ", $request['checkoutMessage']);
        }
        
        return CheckoutBusiness::checkoutMessage($user_id, $checkout_message);
    }

    public function confirmCheckout(Request $request, $user_id, $shop_id)
    {
        if($request['phone'] == 'null' || $request['phone'] == ''){
            $phone = null;
        }else{
            $phone = str_replace("%20", " ", $request['phone']);
        }
        if($request['postcode'] == 'null'  || $request['postcode'] == ''){
            $postcode = null;
        }else{
            $postcode = str_replace("%20", " ", $request['postcode']);
        }
        if($request['address'] == 'null'  || $request['address'] == ''){
            $address = null;
        }else{
            $address = str_replace("%20", " ", $request['address']);
        }
        if($request['tableNumber'] == 'null'  || $request['tableNumber'] == ''){
            $tableNumber = null;
        }else{
            $tableNumber = str_replace("%20", " ", $request['tableNumber']);
        }
        if($request['time'] == 'null'  || $request['time'] == ''){
            $time = null;
        }else{
            $time = str_replace("%20", " ", $request['time']);
        }
        
        return CheckoutBusiness::confirmCheckout($user_id, $shop_id, $time, $phone, $postcode, $address, $tableNumber);
    }

    public function getLimitTimeOrder($shop_id)
    {
        return CheckoutBusiness::getLimitTimeOrder($shop_id);
    }

    public function listShops($openedShops)
    {
        return Util::listShops($openedShops);
    }

    public function sendMail(Request $request)
    {
        if($request['name'] == 'null' || $request['name'] == ''){
            $name = null;
        }else{
            $name = str_replace("%20", " ", $request['name']);
        }
        if($request['sender'] == 'null' || $request['sender'] == ''){
            $sender = null;
        }else{
            $sender = str_replace("%20", " ", $request['sender']);
        }
        if($request['receiver'] == 'null' || $request['receiver'] == ''){
            $receiver = null;
        }else{
            $receiver = str_replace("%20", " ", $request['receiver']);
        }
        if($request['message'] == 'null' || $request['message'] == ''){
            $message = null;
        }else{
            $message = str_replace("%20", " ", $request['message']);
        }
        
        return Util::sendMail($name, $sender, $receiver, $message, null, null);
    }

    public function listCountries()
    {
        return Util::listCountries();
    }

    public function paymentConfirmation(Request $request, $user_id)
    {
        if($request['transactionId'] == 'null' || $request['transactionId'] == ''){
            $transactionId = null;
        }else{
            $transactionId = str_replace("%20", " ", $request['transactionId']);
        }
        if($request['retrievalReference'] == 'null' || $request['retrievalReference'] == ''){
            $retrievalReference = null;
        }else{
            $retrievalReference = str_replace("%20", " ", $request['retrievalReference']);
        }
        
        return CheckoutBusiness::paymentConfirmation($user_id, $transactionId, $retrievalReference);
    }
}
