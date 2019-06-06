<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth; 
use App\Business\CustomerBusiness;
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
use App\Customer;
use App\Shop;
use App\Checkout;
use App\CheckoutItem;
use App\CheckoutItemExtra;

class ApiController extends Controller
{
    const EMAIL_ADDRESS = "ftcdevsolutions@gmail.com";

    public function findOrCreateCustomer(Request $request)
    {
        $customer = Customer::where('provider_id', '=', $request['provider_id'])->first();

        if(isset($customer)){
            return CustomerBusiness::findCustomer($request);
            return response()->json([
                'customer' => $customer,
                'message' => 'Customer found.',
                'error' => false
            ], 200);
        }else{
            return CustomerBusiness::createCustomer($request);
        }
    }

    public function updateCostumer(Request $request, $id)
    {
        return CustomerBusiness::updateCustomer($request, $id);
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

    public function listOrderHistory($customer_id, $shop_id)
    {
        return OrderBusiness::listOrderHistory($customer_id, $shop_id);
    }

    public function findOrderHistory($id)
    {   
        return OrderBusiness::getOrderDetails($id);
    }

    public function orderAgain($id, $customer_id, $shop_id)
	{
		return OrderBusiness::orderAgain($id, $customer_id, $shop_id);
	}

    public function getOrderItems($id)
    {   
        return (new OrderHistoryController())->getOrderItems($id, 'api');
    }

    public function getShoppingCart($customer_id, $shop_id)
    {
        return CheckoutBusiness::shoppingCart($customer_id, $shop_id);
    }

    public function deleteShoppingCart($customer_id)
    {
        return CheckoutBusiness::deleteShoppingCart($customer_id);
    }

    public function addItemToShoppingCart(Request $request, $customer_id, $shop_id)
    {
        $data = $request->all();
        $menuExtras = explode(',', $data['menuExtras']);
        foreach($menuExtras as $menuextra_id){
            $data['menuextra_'.$menuextra_id] = $menuextra_id;
        }
        return CheckoutBusiness::addItem($data, $customer_id, $shop_id);
    }

    public function removeItemFromShoppingCart($customer_id, $shop_id, $checkoutitem_id)
    {
        return CheckoutBusiness::removeItem($checkoutitem_id, $shop_id, $customer_id);
    }

    public function plusItemToShoppingCart($customer_id, $shop_id, $checkoutitem_id)
    {
        return CheckoutBusiness::plusItem($checkoutitem_id, $shop_id, $customer_id);
    }

    public function minusItemFromShoppingCart($customer_id, $shop_id, $checkoutitem_id)
    {
        return CheckoutBusiness::minusItem($checkoutitem_id, $shop_id, $customer_id);
    }

    public function plusRiderTip($customer_id, $shop_id)
    {
        return CheckoutBusiness::plusTip($customer_id, $shop_id);
    }

    public function minusRiderTip($customer_id, $shop_id)
    {
        return CheckoutBusiness::minusTip($customer_id, $shop_id);
    }

    public function deliverOrCollect(Request $request, $customer_id, $shop_id)
    {
        if($request['deliverOrCollect'] == 'null'  || $request['deliverOrCollect'] == ''){
            $deliverOrCollect = 'deliver_address';
        }else{
            $deliverOrCollect = $request['deliverOrCollect'];
        }
        return CheckoutBusiness::deliverOrCollect($customer_id, $shop_id, $deliverOrCollect);
    }

    public function checkoutMessage(Request $request, $customer_id, $shop_id)
    {
        if($request['checkoutMessage'] == 'null' || $request['checkoutMessage'] == ''){
            $checkout_message = null;
        }else{
            $checkout_message = str_replace("%20", " ", $request['checkoutMessage']);
        }
        
        return CheckoutBusiness::checkoutMessage($customer_id, $shop_id, $checkout_message);
    }

    public function confirmCheckout(Request $request, $customer_id, $shop_id)
    {
        if($request['name'] == 'null' || $request['name'] == ''){
            $name = null;
        }else{
            $name = str_replace("%20", " ", $request['name']);
        }
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
        
        return CheckoutBusiness::confirmCheckout($customer_id, $shop_id, $time, $name, $phone, $postcode, $address, $tableNumber);
    }

    public function getLimitTimeOrder($shop_id)
    {
        return CheckoutBusiness::getLimitTimeOrder($shop_id);
    }

    public function listShops($openedShops)
    {
        return Util::listShops($openedShops);
    }

    public function sendMailContactus(Request $request)
    {
        if($request['name'] == 'null' || $request['name'] == ''){
            $name = null;
        }else{
            $name = str_replace("%20", " ", $request['name']);
        }
        if($request['reply'] == 'null' || $request['reply'] == ''){
            $reply = null;
        }else{
            $reply = str_replace("%20", " ", $request['reply']);
        }
        if($request['message'] == 'null' || $request['message'] == ''){
            $message = null;
        }else{
            $message = str_replace("%20", " ", $request['message']);
        }

        return Util::sendEmailContactus($name, $reply, $message);        
    }

    public function listCountries()
    {
        return Util::listCountries();
    }

    public function paymentConfirmation(Request $request, $customer_id, $shop_id)
    {
        if($request['email'] == 'null' || $request['email'] == ''){
            $email = null;
        }else{
            $email = str_replace("%20", " ", $request['email']);
        }
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
        
        return CheckoutBusiness::paymentConfirmation($customer_id, $shop_id, $email, $transactionId, $retrievalReference);
    }
}
