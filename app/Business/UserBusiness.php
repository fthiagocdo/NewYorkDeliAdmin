<?php

namespace App\Business;

use Auth;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Firebase\Auth\Token\Exception\InvalidToken;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\User;
use App\Shop;
use App\LoginToken;

class UserBusiness
{
	public static function createUser($data) 
	{
        $return['error'] = false;
        $return['message'] = '';

        $msgError = UserBusiness::validateUserBasicInfo($data);
        if(strlen($msgError) == 0){
            $return = UserBusiness::createUserInDatabase($data);
            $user = $return['user'];
            if($return['error']){
                return $return;
            }else{
                $return = UserBusiness::createUserInFirebase($data);
                if($return['error']){
                    $user->delete();
                    return $return;
                }else{
                    $user->password = $firebaseUser->uid;
                }
            }

            $return['user'] = $user;
            $return['error'] = false;
            $return['message'] = 'User created successfully.';
            return $return;
        }else{
            $return['error'] = true;
            $return['message'] = $msgError;
            return $return;
        }
    }

    public static function signIn($data)
    {
        $return['error'] = false;
        $return['message'] = '';

        if(!$data['idToken']){
            $return['error'] = true;
            $return['message'] = 'Login Error. Please, inform your credentials again.';
            return $return;
        }else{
            $firebase = UserBusiness::getFirebase();
            
            $idTokenString = $data['idToken'];
            $provider = $data['provider'];

            try {
                $verifiedIdToken = $firebase->getAuth()->verifyIdToken($idTokenString, false, true);
            } catch (InvalidToken $e) {
                $return['error'] = true;
                $return['message'] = $e->getMessage();
                return $return;
            }
            
            $email = $verifiedIdToken->getClaim('email');
            $firebaseUser = $firebase->getAuth()->getUserByEmail($email);
            
            $user = User::where('email', '=', $email)->first();
            
            //Email Login Failed - User not registered
            if(!isset($user)){
                $return['error'] = true;
                $return['message'] = 'E-mail is not registered.';
                return $return;
            //Blocked User
            }else if($user->nu_error_login > 4){ 
                $return['error'] = true;
                $return['message'] = 'Number of login attempts exceeded!';
                return $return;
            //Email Login Success
            }else if(Auth::loginUsingId($user->id)){
                //User hasn't permission to access
                if($user->hasRole('CUSTOMER')){
                    Auth::logout();
                    $return['error'] = true;
                    $return['message'] = 'Sorry, but you have no permission to access this website.<br>If you want to make a order, please download our app.';
                    return $return;
                //User has permission to access
                }else{
                    $user->nu_error_login = 0;
                    $user->update();
                    
                    $return['error'] = false;
                    $return['message'] = 'Success Login';
                    return $return;
                }
            //Email Login Failed - Email/Password does not match
            }else{
                $nu_error_login = $user->nu_error_login;
                $user->nu_error_login = $nu_error_login + 1;
                $user->update();

                $return['error'] = true;
                $return['message'] = 'Invalid email or password.';
                return $return;
            }
        }
    }

    public static function signInSocial($data)
    {
        $return['error'] = false;
        $return['message'] = '';
       
        //User is already in the system with other provider
        if(User::where('email', '=', $data['email'])->where('provider', '!=', $data['provider'])->count()){
            $return['error'] = true;
            $return['message'] = 'The e-mail is already being used.';
            return $return;
        }else{
            //Don't create user in database if the user have logged before in the system
            if(!User::where('email', '=', $data['email'])
                ->first()){
                return UserBusiness::createUser($data);
            //Email Login Success
            }else if(User::where('email', '=', $data['email'])->count()){
                $user = User::where('email', '=', $data['email'])->first();
                $return['user'] = $user;
                $return['error'] = false;
                $return['message'] = 'Success Login';
                return $return;
            }
        }
    }

    public static function changePassword($data)
    {
        $msgError = UserBusiness::validateChangePassword($data);
        if(strlen($msgError) == 0){
            try{
                $email = $data['email'];
                $firebase = UserBusiness::getFirebase();
                $firebaseUser = $firebase->getAuth()->getUserByEmail($email);
                
                $password = $data['password'];
                $uid = $firebaseUser->uid;
                $updatedUser = $firebase->getAuth()->changeUserPassword($uid, $password);

                $return['error'] = false;
                $return['message'] = 'Password updated successfully.';
                return $return;
            }catch(Exception $e){
                $return['error'] = true;
                $return['message'] = $e->getMessage();
                return $return;
            }
        }else{
            $return['error'] = true;
            $return['message'] = $msgError;
            return $return;
        }
    }

    public static function getAvatar($user)
    {   
        $path = storage_path('app/public/avatars/'.$user->avatar);
        
        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }
    
    private static function validateUserBasicInfo($data)
	{
		if(!isset($data['name'])){
            return "Field 'name' must be informed.";
        } else if(!isset($data['email'])){
            return "Field 'e-mail' must be informed.";
        } else if(!isset($data['avatar'])){
            return "Profile image must be selected.";
        } else if($data['provider'] == 'email' && !isset($data['password'])){
            return "Field 'password' must be informed.";
        } else if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return 'E-mail is not valid.';
        } else if($data['provider'] == 'email' && strlen($data['password']) < 8){
            return 'The password must be at least 8 characters long.';
        } else if(User::where('email', '=', $data['email'])
                    ->first()){
            return 'The e-mail is already being used.';
        }

        return '';
    }

    private static function validateChangePassword($data)
	{
		if(!isset($data['password'])){
            return 'All fields must be informed.';
        } else if(!isset($data['confirm_password'])){
            return 'All fields must be informed.';
        } else if ($data['password'] != $data['confirm_password']) {
            return 'New Password and Confirm New Password do not match.';
        } else if(strlen($data['password'])<8){
            return 'New password must be at least 8 characters long.';
        }

        return '';
	}
    
    private static function getFirebase() {
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/google-service-account.json');

        $firebase = (new Factory)
            ->withServiceAccount($serviceAccount)
            ->create();

        return $firebase;
    }

    private static function createUserInDatabase($data) 
	{
        try{
            $user = new User();
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->provider = $data['provider'];
            $user->receive_notifications = true;
            $user->shop_id = Shop::all()->first()->id;
            $user->avatar = str_replace('public/avatars/', '', $data['avatar']);
            $user->password = $data['password'];
            $user->save();

            $user->addRole('customer');

            $return['error'] = false;
            $return['message'] = 'User created successfully.';
            $return['user'] = $user;
            
            return $return;
        }catch (\Exception $e) {
            $return['error'] = true;
            $return['message'] = $e->getMessage();
            return $return;
        }
    }

    private static function createUserInFirebase($data) 
	{
        try{
            $firebase = UserBusiness::getFirebase();
            $auth = $firebase->getAuth();

            $userProperties = [
                'email' => $data['email'],
                'emailVerified' => false,
                'password' => $data['password'],
                'disabled' => false,
            ];
            
            $user = $auth->createUser($userProperties);

            dd($user);
            //$return['user_uid'] = $user->;
            $return['error'] = false;
            $return['message'] = 'User created successfully.';
            return $return;
        }catch (\Exception $e) {
            $return['error'] = true;
            $return['message'] = $e->getMessage();
            return $return;
        }
    }

}