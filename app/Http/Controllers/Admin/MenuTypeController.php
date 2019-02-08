<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Business\MenuBusiness;
use App\Http\Controllers\Controller;
use App\Util\Util;
use App\MenuType;

class MenuTypeController extends Controller
{
    public function index($mode = null){
        if(auth()->user()->can('menu_list')){
            $return = MenuBusiness::findMenuTypes(4);
            return view('admin.menutype.index')
                ->with('registers', $return['list'])
                ->with('currentMenu', 'menu');
        }else{
            return Util::redirectHome();
        }
    }

    public function find($id, $mode = null)
    {
        $register = MenuType::find($id);

        if($mode == 'api'){
            if(isset($register)){
                return response()->json($register);
            }else{
                return response()->json([
                    'messsage' => 'Register not found.',
                    'status' => 'ERROR'
                ]);
            }
        }
    }

    public function add()
    {
        if(auth()->user()->can('menu_add')){
            return view('admin.menutype.add')
            	->with(['previousPage' => 'admin.menutype']);
        }else{
           return Util::redirectHome();
        }
    }

    public function save(Request $request)
    {
        if(auth()->user()->can('menu_add')){
            $data = $request->all();

            $register = new MenuType();
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
	        $register = MenuType::find($id);
	        
	        \Session::flash('register', $register);

            return view('admin.menutype.edit')
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
            MenuType::find($id)->delete();

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
        if(!isset($request['name'])){
            return 'All fields must be filled.';
        }

        return null;
    }
}
