<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Util\Util;
use App\User;
use App\Role;
use App\Shop;

class UserController extends Controller
{
    public function index(){
        if(auth()->user()->can('users_list')){
    		$admin = Role::where('name', '=', 'ADMIN')->first();
    		//Returns all users less admin user and himself
            $registers = User::where('id', '<>', auth()->user()->id)
            	->where('id', '<>', $admin->users()->first()->id)
            	->orderBy('id', 'asc')->paginate(5);

            return view('admin.user.index')
            		->with(['registers' => $registers])
                    ->with(['currentMenu' => 'users']);
        }else{
           return Util::redirectHome();
        }
    }

    public function search(Request $request){
        if(auth()->user()->can('users_search')){
        	$filters = $request->all();

        	if($filters['id'] == ''){
        		$filterId = [
        			['id', '<>', null]
        		];
        	}else{
        		$filterId = [
        			['id', '=', (int) $filters['id']]
        		];
        	}

        	if($filters['name'] == ''){
        		$filterName = [
        			['name', '<>', null]
        		];
        	}else{
        		$filterName = [
        			['name', 'like', '%'.$filters['name'].'%']
        		];
        	}

        	if($filters['email'] == ''){
        		$filterEmail = [
        			['email', '<>', null]
        		];
        	}else{
        		$filterEmail = [
        			['email', 'like', '%'.$filters['email'].'%']
        		];
        	}

        	$admin = Role::where('name', '=', 'ADMIN')->first();

        	$registers = User::where('id', '<>', auth()->user()->id)
                ->where('id', '<>', $admin->users()->first()->id)
    	    	->where($filterId)
    	    	->where($filterName)
    	    	->where($filterEmail)
    	    	->orderBy('id', 'asc')->paginate(5);
        	
        	return view('admin.user.index')
        		->with(['registers' => $registers])
        		->with(['filters' => $filters])
                ->with(['currentMenu' => 'users']);
        }else{
           return Util::redirectHome();
        }
    }

    public function details($id)
    {
        if(auth()->user()->can('users_list')){
            $register = User::find($id);

            $shops = Shop::where('available', '=', true)->get();
            
            \Session::flash('register', $register);

            return view('admin.user.edit')
                ->with(['shops' => $shops])
                ->with(['editable' => false])
                ->with(['previousPage' => 'admin.user']);
        }else{
           return Util::redirectHome();
        }
    }

    public function edit($id)
    {
        if(auth()->user()->id == $id){
	        $register = User::find($id);

            $shops = Shop::where('available', '=', true)->get();
	        
	        \Session::flash('register', $register);

	        if(auth()->user()->id == $id){
	        	return view('admin.user.edit')
                    ->with(['shops' => $shops])
                    ->with(['editable' => true])
            		->with(['currentMenu' => 'profile']);
	        }else{
	        	return view('admin.user.edit')
            		->with(['previousPage' => 'admin.user']);
	        }
        }else{
           return Util::redirectHome();
        }
    }

    public function update(Request $request, $id)
    {
        if(auth()->user()->id == $id){
    		$register = User::find($id);

            $data = $request->all();

            $msgError = $this->validateUser($data);
            if(strlen($msgError) == 0){
	            $register->name = $data['name'];
	            $register->phone_number = $data['phoneNumber'];
	            $register->postcode = $data['postcode'];
	            $register->address = $data['address'];
	            $register->shop_id = $data['preferredShop'];
	            if(isset($data['receiveNotifications'])){
	            	$register->receive_notifications = 'yes';
	            }else{
	            	$register->receive_notifications = 'no';
	            }
	            if(isset($data['password'])){
	            	$register->password = bcrypt($data['password']);
	            }

	            if($request->file('image-med')){
	                $file = $request->file('image-med');
	            }else if($request->file('image-mobile')){
	                $file = $request->file('image-mobile');
	            }else{
	                $file = null;
	            }

	        	if($file){
	        		$rand = rand(11111, 99999);
	        		$diretorio = "img/users/".$register->email;
	        		$extensao = $file->guessClientExtension();
	        		$nomeArquivo = "_img_".$rand.".".$extensao;
	        		$file->move($diretorio, $nomeArquivo);
	        		$register->avatar = $diretorio."/".$nomeArquivo;
	        	}

                $register->update();

                \Session::flash('register', $register);

                $message = 'Profile updated successfully.';
                $typeMessage = 'green white-text';

                return redirect()->route('admin.user.edit', $id)
                    ->with(['message' => $message])
                    ->with(['typeMessage' => $typeMessage])
                    ->with(['editable' => true])
                    ->with(['currentMenu', 'profile']);
            }else{
                \Session::flash('register', $register);

                return redirect()->back()
                    ->with(['message' => $msgError])
                    ->with(['editable' => true])
                    ->with(['typeMessage' => 'red white-text'])
                    ->with(['currentMenu', 'profile']);
            }
        }else{
           return Util::redirectHome();
        }
    }

    public function role($id)
    {
        if(auth()->user()->can('user_edit')){
            $user = User::find($id);

            $roles = Role::where('name', '<>', 'ADMIN')->orderBy('name', 'asc')->get()->diff($user->roles);

            return view('admin.user.role')
                ->with('user', $user)
                ->with('roles', $roles)
                ->with(['previousPage' => 'admin.user']);
        }else{
           return Util::redirectHome();
        }
    }

    public function addRole(Request $request, $id)
    {
        if(auth()->user()->can('user_edit')){
            $data = $request->all();
            $role = Role::find($data['role_id']);

            $user = User::find($id);
            $user->addRole($role);

            $roles = Role::where('name', '<>', 'ADMIN')->get()->diff($user->roles);

            $message = 'Role added successfully.';
            $typeMessage = 'green white-text';

            return redirect()->route('admin.user.role', $user->id)
                ->with( ['message' => $message] )
                ->with( ['typeMessage' => $typeMessage] )
                ->with( ['previousPage' => 'admin.user'] );
        }else{
           return Util::redirectHome();
        }
    }

    public function removeRole($id, $role_id)
    {
        if(auth()->user()->can('user_edit')){
            $role = Role::find($role_id);

            $user = User::find($id);
            $user->removeRole($role);

            $roles = Role::where('name', '<>', 'ADMIN')->get()->diff($user->roles);

            $message = 'Role removed successfully.';
            $typeMessage = 'green white-text';

            return redirect()->route('admin.user.role', $user->id)
                ->with( ['message' => $message] )
                ->with( ['typeMessage' => $typeMessage] )
                ->with( ['previousPage' => 'admin.user'] );
        }else{
           return Util::redirectHome();
        }
    }

    private function validateUser($data)
    {
        if(!isset($data['name'])){
            return 'Fields with * must be filled.';
        } else if(isset($data['password']) && strlen($data['password'])<8){
            return 'The password must be at least 8 characters long.';
        } else if (isset($data['password']) &&  $data['password'] != $data['confirmPassword']) {
            return 'Password and Confirm Password do not match.';
        } else if(!isset($data['phoneNumber'])){
            return 'Fields with * must be filled.';
        } else if(!isset($data['postcode'])){
            return 'Fields with * must be filled.';
        } else if(!isset($data['address'])){
            return 'Fields with * must be filled.';
        } else if(!isset($data['preferredShop'])){
            return 'Fields with * must be filled.';
        } 

        return '';
    }
}
