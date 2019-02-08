<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Util\Util;
use App\Role;
use App\Permission;

class RoleController extends Controller
{
    public function index(){
        if(auth()->user()->can('roles_list')){
            $registers = Role::orderBy('name', 'asc')->get();

            return view('admin.role.index')
            		->with(['registers' => $registers])
                    ->with(['currentMenu' => 'roles']);
        }else{
           return Util::redirectHome();
        }
    }

    public function add()
    {
        if(auth()->user()->can('role_add')){
            return view('admin.role.add')
            	->with(['previousPage' => 'admin.role']);
        }else{
           return Util::redirectHome();
        }
    }

    public function save(Request $request)
    {
        if(auth()->user()->can('role_add')){
            $data = $request->all();

            $register = new Role();
            $register->name = strtoupper($data['name']);
            $register->description = $data['description'];

            $msgError = $this->validateRole($register);
            if(!isset($msgError)){
                $register->save();

                $message = 'Role created successfully.';
                $typeMessage = 'green white-text';

                return redirect()->route('admin.role')
                    ->with(['message' => $message])
                    ->with(['typeMessage' => $typeMessage]);
            }else{
            	\Session::flash('register', $register);

                return redirect()->back()
                	->with(['previousPage' => 'admin.role'])
                    ->with(['message' => $msgError])
                    ->with(['typeMessage' => 'red white-text']);
            }
        }else{
           return Util::redirectHome();
        }
    }

    public function edit($id)
    {
        $register = Role::find($id);

        if(auth()->user()->can('role_edit')){
        	if($register->isAdmin()){
                $message = 'The register can not be updated.';
                $typeMessage = 'red white-text';

                return redirect()->back()
                	->with(['currentMenu' => 'role'])
                    ->with(['message' => $message])
                    ->with(['typeMessage' => 'red white-text']);
            }else{
    	        \Session::flash('register', $register);

                return view('admin.role.edit')
                	->with(['previousPage' => 'admin.role']);
    	    }
        }else{
           return Util::redirectHome();
        }
    }

    public function update(Request $request, $id)
    {
        $register = Role::find($id);

        if(auth()->user()->can('role_edit')){
    		//If is Admin, it can not be updated
    		if($register->isAdmin()){
                return redirect()->back()
                	->with(['currentMenu' => 'role'])
                    ->with(['message' => 'The register can not be updated.'])
                    ->with(['typeMessage' => 'red white-text']);
            }else{
    	        $data = $request->all();

    	        $register->name = strtoupper($data['name']);
    	        $register->description = $data['description'];

                $msgError = $this->validateRole($register);
                if(!isset($msgError)){
        	        $register->update();

        	        $message = 'Role update successfully.';
                    $typeMessage = 'green white-text';

                    return redirect()->route('admin.role')
                        ->with(['message' => $message])
                        ->with(['typeMessage' => $typeMessage]);
                }else{
                    return redirect()->back()
                        ->with(['message' => $msgError])
                        ->with(['typeMessage' => 'red white-text'])
                        ->with(['previousPage' => 'admin.role']);
                }
    	    }
        }else{
           return Util::redirectHome();
        }
    }

    public function delete($id)
    {
        $register = Role::find($id);

        if(auth()->user()->can('role_delete')){
        	if($register->isAdmin()){
                return redirect()->back()
                	->with(['currentMenu' => 'role'])
                    ->with(['message' => 'The register can not be deleted.'])
                    ->with(['typeMessage' => 'red white-text']);
            }else{
                Role::find($id)->delete();

                $message = 'Register deleted successfully.';
                $typeMessage = 'green white-text';

                return redirect()->route('admin.role')
                    ->with( ['message' => $message] )
                    ->with( ['typeMessage' => $typeMessage] );
            }
        }else{
           return Util::redirectHome();
        }
    }

    public function permission($id)
    {
        $role = Role::find($id);

        if(auth()->user()->can('role_edit')){
            if($role->isAdmin()){
                return redirect()->back()
                    ->with(['currentMenu' => 'role'])
                    ->with(['message' => 'The register can not be updated.'])
                    ->with(['typeMessage' => 'red white-text']);
            }else{
                $permissions = Permission::orderBy('name', 'asc')->get()->diff($role->permissions);

                return view('admin.role.permission')
                    ->with('role', $role)
                    ->with('permissions', $permissions)
                    ->with(['previousPage' => 'admin.role']);
            }
        }else{
           return Util::redirectHome();
        }
    }

    public function addPermission(Request $request, $role_id)
    {
        $role = Role::find($role_id);

        if(auth()->user()->can('role_edit')){
            if($role->isAdmin()){
                return redirect()->back()
                    ->with(['currentMenu' => 'role'])
                    ->with(['message' => 'The register can not be updated.'])
                    ->with(['typeMessage' => 'red white-text']);
            }else{
                $data = $request->all();
                $permission = Permission::find($data['permission_id']);

                $role->addPermission($permission);

                $message = 'Permission added successfully.';
                $typeMessage = 'green white-text';

                return redirect()->route('admin.role.permission', $role->id)
                    ->with( ['message' => $message] )
                    ->with( ['typeMessage' => $typeMessage] )
                    ->with( ['previousPage' => 'admin.role'] );
            }
        }else{
           return Util::redirectHome();
        }
    }

    public function removePermission($role_id, $permission_id)
    {
        $role = Role::find($role_id);
        
        if(auth()->user()->can('role_edit')){
            if($role->isAdmin()){
                return redirect()->back()
                    ->with(['currentMenu' => 'role'])
                    ->with(['message' => 'The register can not be updated.'])
                    ->with(['typeMessage' => 'red white-text']);
            }else{
                $permission = Permission::find($permission_id);

                $role = Role::find($role_id);
                $role->removePermission($permission);

                $message = 'Permission removed successfully.';
                $typeMessage = 'green white-text';

                return redirect()->route('admin.role.permission', $role->id)
                    ->with( ['message' => $message] )
                    ->with( ['typeMessage' => $typeMessage] )
                    ->with( ['previousPage' => 'admin.role'] );
            }
        }else{
           return Util::redirectHome();
        }
    }

    //If there is not message error, it moves forward
    private function validateRole($role)
    {
        if(!isset($role->name)){
            return 'Fields with * must be filled.';
        } else if(!isset($role->description)){
            return 'Fields with * must be filled.';
        } else if(Role::where('name', '=', $role->name)->count()){
            if(!isset($role->id) || 
                Role::where('name', '=', $role->name)->first()->id != $role->id){
                return 'Paper already registered.';
            }
        }

        return null;
    }
}
