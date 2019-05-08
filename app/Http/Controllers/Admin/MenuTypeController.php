<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Business\MenuBusiness;
use App\Http\Controllers\Controller;
use App\Util\Util;
use App\MenuType;

class MenuTypeController extends Controller
{
    public function index(){
        if(auth()->user()->can('menu_list')){
            $shops = Util::listShops(false);
            $return = MenuBusiness::findMenuTypes($shops['list'][0]->id);
            return view('admin.menutype.index')
                ->with('shops', $shops['list'])
                ->with('shop_id', $shops['list'][0]->id)
                ->with('registers', $return['list'])
                ->with('currentMenu', 'menu');
        }else{
            return Util::redirectHome();
        }
    }

    public function shop(Request $request)
    {
        if(auth()->user()->can('menu_list')){
            $data = $request->all();
            $shops = Util::listShops(false);
            $return = MenuBusiness::findMenuTypes($data['shop_id']);
            return view('admin.menutype.index')
                ->with('shops', $shops['list'])
                ->with('shop_id', $data['shop_id'])
                ->with('registers', $return['list'])
                ->with('currentMenu', 'menu');
        }else{
            return Util::redirectHome();
        }
    }

    public function find($id)
    {
        $register = MenuType::find($id);

        if(isset($register)){
            return response()->json($register);
        }else{
            return response()->json([
                'messsage' => 'Register not found.',
                'status' => 'ERROR'
            ]);
        }
    }

    public function add()
    {
        if(auth()->user()->can('menu_add')){
            $shops = Util::listShops(false);
            return view('admin.menutype.add')
                ->with('shops', $shops['list'])
            	->with('previousPage', 'admin.menutype');
        }else{
           return Util::redirectHome();
        }
    }

    public function save(Request $request)
    {
        if(auth()->user()->can('menu_add')){
            $data = $request->all();

            $register = new MenuType();
            $register->shop_id = $data['shop_id'];
            $register->name = $data['name'];

            $msgError = $this->validateMenuType($request);
            if(!isset($msgError)){
                $register->save();

                $message = 'Menu type created successfully.';
                $typeMessage = 'green white-text';

                return redirect()->route('admin.menutype')
                    ->with(['message' => $message])
                    ->with(['typeMessage' => $typeMessage]);
            }else{
            	\Session::flash('register', $register);

                return redirect()->back()
                	->with(['previousPage' => 'admin.menutype'])
                    ->with(['message' => $msgError])
                    ->with(['typeMessage' => 'red white-text']);
            }
        }else{
           return Util::redirectHome();
        }
    }

    public function edit($id)
    {
        if(auth()->user()->can('menu_edit')){
            $shops = Util::listShops(false);
	        $register = MenuType::find($id);
	        
	        \Session::flash('register', $register);

            return view('admin.menutype.edit')
                ->with('shops', $shops['list'])
            	->with(['previousPage' => 'admin.menutype']);
        }else{
           return Util::redirectHome();
        }
    }

    public function update(Request $request, $id)
    {
        if(auth()->user()->can('menu_edit')){
	        $register = MenuType::find($id);
	        
	        $data = $request->all();

            $register->name = $data['name'];
            $register->shop_id = $data['shop_id'];

            $msgError = $this->validateMenuType($register);
            if(!isset($msgError)){
    	        $register->update();

    	        $message = 'Menu type update successfully.';
                $typeMessage = 'green white-text';

                return redirect()->route('admin.menutype')
                    ->with(['message' => $message])
                    ->with(['typeMessage' => $typeMessage]);
            }else{
                return redirect()->back()
                    ->with(['message' => $msgError])
                    ->with(['typeMessage' => 'red white-text'])
                    ->with(['previousPage' => 'admin.menutype']);
            }
        }else{
           return Util::redirectHome();
        }
    }

    public function delete($id)
    {
        if(auth()->user()->can('menu_delete')){
            $register = MenuType::find($id);
            $register->deleted = true;
            $register->update();

            $message = 'Menu type deleted successfully.';
            $typeMessage = 'green white-text';
            
            return redirect()->route('admin.menutype')
                ->with( ['message' => $message] )
                ->with( ['typeMessage' => $typeMessage] );
        }else{
           return Util::redirectHome();
        }
    }

    //If there is not message error, it moves forward
    private function validateMenuType($request)
    {
        if(!isset($request['shop_id'])){
            return 'All fields must be filled.';
        }else if(!isset($request['name'])){
            return 'All fields must be filled.';
        }

        return null;
    }
}
