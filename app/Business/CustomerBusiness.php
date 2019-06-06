<?php

namespace App\Business;

use Auth;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Firebase\Auth\Token\Exception\InvalidToken;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Business\CheckoutBusiness;
use App\Customer;
use App\Shop;
use App\LoginToken;

class CustomerBusiness
{
	public static function createCustomer($data) 
	{
        try{
            $customer = new Customer();
            $customer->provider_id = $data['provider_id'];
            $customer->provider = $data['provider'];
            $customer->receive_notifications = true;
            $customer->save();

            return response()->json([
                'customer' => $customer,
                'message' => 'Customer added successfully.',
                'error' => false
            ], 200);
        }catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'error' => true
            ], 200);
        }
    }

    public static function findCustomer($data) 
	{
        try{
            $customer = Customer::where('provider_id', '=', $data['provider_id'])->first();

            if($customer->provider != $data['provider']){
                $customer->provider = $data['provider'];
                $customer->update();
            }

            return response()->json([
                'customer' => $customer,
                'message' => 'Customer found.',
                'error' => false
            ], 200);
        }catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'error' => true
            ], 200);
        }
    }

    public static function updateCustomer($data, $id)
    {
        try{
            $customer = Customer::find($id);
            $customer->name = str_replace("%20", " ", $data['name']);    
            $customer->phone_number = str_replace("%20", " ", $data['phoneNumber']);
            $customer->postcode = str_replace("%20", " ", $data['postcode']);
            $customer->address = str_replace("%20", " ", $data['address']);
            $customer->receive_notifications = str_replace("%20", " ", $data['receiveNotifications']);
            $customer->provider = str_replace("%20", " ", $data['provider']);
            $customer->update();

            return response()->json([
                'customer' => $customer, 
                'error' => false,
                'message' => 'Customer updated successfully.'
            ], 200);
        }catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'error' => true
            ], 200);
        }
    }
}