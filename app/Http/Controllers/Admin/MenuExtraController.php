<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Business\MenuBusiness;
use App\Http\Controllers\Controller;
use App\Util\Util;
use App\MenuExtra;
use App\MenuItem;

class MenuExtraController extends Controller
{
    public function index($menuitem_id){
        if(auth()->user()->can('menu_list')){
            $menuItem = MenuItem::find($menuitem_id);
            $return = MenuBusiness::findMenuExtra($menuitem_id);
            return view('admin.menuextra.index')
                    ->with('registers', $return['list'])
                    ->with('menuitem', $menuItem)
                    ->with('previousPage', 'admin.menutype.menuitem')
                    ->with('parameterPreviousPage', $menuItem->type->id);
        }else{
            return Util::redirectHome();
        }
    }

    public function find($id, $mode = null)
    {
        $register = MenuExtra::find($id);

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

    public function add($menuitem_id)
    {
        if(auth()->user()->can('menu_add')){
            $menuItem = MenuItem::find($menuitem_id);

            return view('admin.menuextra.add')
                ->with(['menuitem' => $menuItem])
                ->with(['previousPage' => 'admin.menutype.menuitem.menuextra'])
                ->with(['parameterPreviousPage' => $menuItem->id]);
        }else{
           return Util::redirectHome();
        }
    }

    public function save(Request $request, $menuitem_id)
    {
        if(auth()->user()->can('menu_add')){
            $menuItem = MenuItem::find($menuitem_id);

            $data = $request->all();

            $register = new MenuExtra();
            $register->name = $data['name'];
            $register->price = $data['price'];
            $register->menuitem_id = $menuItem->id;

            $msgError = $this->validateMenuExtra($register);
            if(!isset($msgError)){
                $register->save();

                \Session::flash('register', $register);

                $message = 'Menu extra added successfully.';
                $typeMessage = 'green white-text';

                return redirect()->route('admin.menutype.menuitem.menuextra', $menuItem->id)
                    ->with(['message' => $message])
                    ->with(['typeMessage' => $typeMessage])
                    ->with(['previousPage', 'admin.menutype.menuitem'])
                    ->with(['parameterPreviousPage' => $menuItem->id]);
            }else{
                \Session::flash('register', $register);

                return redirect()->back()
                    ->with(['previousPage' => 'admin.menutype.menuitem'])
                    ->with(['parameterPreviousPage' => $menuItem->id])
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
            $register = MenuExtra::find($id);
            
            \Session::flash('register', $register);

            return view('admin.menuextra.edit')
                ->with(['menuitem' => $register->menuItem])
                ->with(['previousPage' => 'admin.menutype.menuitem.menuextra'])
                ->with(['parameterPreviousPage' => $register->menuItem->id]);
        }else{
           return Util::redirectHome();
        }
    }

    public function update(Request $request, $id)
    {
        if(auth()->user()->can('menu_edit')){
            $data = $request->all();

            $register = MenuExtra::find($id);
            $register->name = $data['name'];
            $register->price = $data['price'];

            $msgError = $this->validateMenuExtra($register);
            if(!isset($msgError)){
                $register->update();

                \Session::flash('register', $register);

                $message = 'Menu extra updated successfully.';
                $typeMessage = 'green white-text';

                return redirect()->route('admin.menutype.menuitem.menuextra', $register->menuItem->id)
                    ->with(['message' => $message])
                    ->with(['typeMessage' => $typeMessage])
                    ->with(['previousPage', 'admin.menutype.menuitem'])
                    ->with(['parameterPreviousPage' => $register->menuItem->type->id]);
            }else{
                \Session::flash('register', $register);

                return redirect()->back()
                    ->with(['previousPage' => 'admin.menutype.menuitem'])
                    ->with(['parameterPreviousPage' => $register->menuItem->type->id])
                    ->with(['message' => $msgError])
                    ->with(['typeMessage' => 'red white-text']);
            }
        }else{
           return Util::redirectHome();
        }
    }

    public function delete($id)
    {
        if(auth()->user()->can('menu_delete')){
            $menuitem_id = MenuExtra::find($id)->menuItem->id;
            MenuExtra::find($id)->delete();

            $message = 'Menu extra deleted successfully.';
            $typeMessage = 'green white-text';

            return redirect()->route('admin.menutype.menuitem.menuextra', $menuitem_id)
                ->with( ['message' => $message] )
                ->with( ['typeMessage' => $typeMessage] );
        }else{
           return Util::redirectHome();
        }
    }

    //If there is not message error, it moves forward
    private function validateMenuExtra($register)
    {
        if(!isset($register->name)){
            return 'All fields must be filled.';
        }else if(!isset($register->price)){
            return 'All fields must be filled.';
        }

        return null;
    }
}
