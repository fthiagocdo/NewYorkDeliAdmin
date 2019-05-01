<?php

namespace App\Http\Controllers\Site;

use Socialite;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Business\UserBusiness;
use App\User;
use App\LoginToken;
use App\Shop;

class LoginController extends Controller
{
    public function index()
	{
		return view('site.login.index')
            ->with('currentMenu', 'login');
	}

	public function login(Request $request) 
	{
        $data = $request->all();
        $return = UserBusiness::signIn($data);

		if($return['error']){
			return redirect()->back()
                ->with('name', $data['email'])
                ->with('message', $return['message'])
                ->with('typeMessage', 'red white-text');
		}else{
			return redirect()->route('site.home');
		}
    }

	public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        $credentials = Socialite::driver($provider)->stateless()->user();
        
        $data['name'] = $credentials->name;
        $data['email'] = $credentials->email;
        $data['provider'] = $provider;
        $data['avatar'] = $credentials->avatar_original;
        $data['password'] = $provider.'_'.Hash::make(str_random(8));
        $return = UserBusiness::signInSocial($data);

        if($return['error']){
			return redirect()->back()
                ->with('name', $data['email'])
                ->with('message', $return['message'])
                ->with('typeMessage', 'red white-text');
		}else{
            Auth::login($return['user'], true);
			return redirect()->route('site.home');
		}
    }

    public function findOrCreateUser($user, $provider){
        $authUser = User::where('provider_id', '=', $user->id)->first();
        if($authUser){
            return $authUser;
        }else{
            //Change the size of the avatar
            if($provider == 'google'){
                $img = substr($user->avatar, 0, strpos($user->avatar, '?sz=50'));
            }
            $createdUser = User::create([
                'name' => $user->name,
                'email' => $user->email,
                'provider' => $provider,
                'provider_id' => $user->id,
                'avatar' => $img.'?sz=200',
                'shop_id' => Shop::all()->first()->id
            ]);

            $createdUser->addRole('customer');

            return $createdUser;
        }
    }

    public function forgotPassword()
    {
        return view('site.login.forgot')
        	->with('previousPage', 'site.login');
    }

	public function resetPassword(Request $request) 
	{
		$email = 'fthiagocdo@gmail.com';

		$data = $request->all();

		$msgError = $this->validateRecoverPassword($data['email']);
        if(strlen($msgError) == 0){
        	$user = User::where('email', '=', $email)->first();

        	LoginToken::where('email', '=', $data['email'])->delete();

        	$loginToken = new LoginToken();
        	$loginToken->email = $data['email'];
        	$loginToken->token = substr(md5(uniqid($user->name, true)).md5(uniqid($user->email, true)), 0, 50);
        	$loginToken->save();

        	\Mail::send('emails.reset_password', ['name'=>$user->name, 'token'=>$loginToken->token], function($m) use ($user, $email){
                $m->from($email, 'New York Deli');
                $m->to($user->email, $user->name);
                $m->subject('Reset Your New York Deli Password');
            });

            $message = 'Instructions for resetting your password<br>have been sent to your email address.';
            $typeMessage = 'green white-text';

            return redirect()->route('site.login')
                ->with( ['message' => $message] )
                ->with( ['typeMessage' => $typeMessage] );
        }else{
            return redirect()->back()
            	->with( ['email' => $data['email']] )
                ->with( ['message' => $msgError] )
                ->with( ['typeMessage' => 'red white-text'] );
        }
	}

	public function changePassword($token)
	{
		$loginToken = LoginToken::where('token', '=', $token)->first();

		if(isset($loginToken)){
			$user = User::where('email', '=', $loginToken->email)->first();

			return view('site.login.change')
				->with('user', $user)
            	->with('previousPage', 'site.login');;
		}else{
			$message = 'Invalid token.';
            $typeMessage = 'red white-text';

			return redirect()->route('site.login')
                ->with( ['message' => $message] )
                ->with( ['typeMessage' => $typeMessage] );
		}
	}

	public function savePassword(Request $request, $id)
	{
        $data = $request->all();
        
        $return = UserBusiness::changePassword($data);

        if($return['error']){
            return redirect()->back()
                ->with('name', $data['email'])
                ->with('message', $return['message'])
                ->with('typeMessage', 'red white-text');
        }else{
            return redirect()->route('site.login')
                ->with('message', $return['message'])
                ->with('typeMessage', 'green white-text');
        }
	}

	public function logout()
    {
        if(Auth::check()){
            Auth::logout();
        }

        return redirect()->route('site.home');
    }

	public function validateLogin($user)
	{
		if(!isset($user->name)){
            return 'All fields must be informed.';
        } else if(!isset($user->email)){
            return 'All fields must be informed.';
        } else if(!isset($user->password)){
            return 'All fields must be informed.';
        } else if (!filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
            return 'E-mail is not valid.';
        } else if(strlen($user->password)<8){
            return 'The password must be at least 8 characters long.';
        } else if(User::where('email', '=', $user->email)
                    ->first()){
            return 'The e-mail is already being used.';
        }

        return '';
	}

	public function validateRecoverPassword($email)
	{
		if(!isset($email)){
            return 'All fields must be informed.';
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return 'E-mail is not valid.';
        } else if(!User::where('email', '=', $email)
                    ->first()){
            return 'E-mail is not registered.';
        }

        return '';
	}
}
