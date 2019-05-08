<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Business\MenuBusiness;
use App\Http\Controllers\Controller;
use App\Util\Util;
use App\MenuType;
use App\MenuItem;

class MenuItemController extends Controller
{
    public function index($menutype_id){
        if(auth()->user()->can('menu_list')){
            $menuType = MenuType::find($menutype_id);
            $return = MenuBusiness::findMenuItem($menutype_id);
            return view('admin.menuitem.index')
                    ->with('registers', $return['list'])
                    ->with('menutype', $menuType)
                    ->with('previousPage', 'admin.menutype');
        }else{
            return Util::redirectHome();
        }
    }

    public function find($id, $mode = null)
    {
        $register = MenuItem::find($id);

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

    public function add($menutype_id)
    {
        if(auth()->user()->can('menu_add')){
            $menuType = MenuType::find($menutype_id);

            return view('admin.menuitem.add')
                ->with(['menutype' => $menuType])
                ->with(['previousPage' => 'admin.menutype']);
        }else{
           return Util::redirectHome();
        }
    }

    public function save(Request $request, $menutype_id)
    {
        if(auth()->user()->can('menu_add')){
            $menutype = MenuType::find($menutype_id);

            $data = $request->all();

            $register = new MenuItem();
            $register->name = $data['name'];
            $register->description = $data['description'];
            $register->price = $data['price'];
            $register->menutype_id = $menutype->id;

            if($request->file('image-med')){
                $file = $request->file('image-med');
            }else if($request->file('image-mobile')){
                $file = $request->file('image-mobile');
            }else{
                $file = null;
            }

            if($file){
                $rand = rand(11111, 99999);
                $diretorio = "img/menu/".$register->type->name;
                $extensao = $file->guessClientExtension();
                $nomeArquivo = "_img_".str_slug($register->name, '_')."_".$rand.".".$extensao;
                $file->move($diretorio, $nomeArquivo);
                $register->image = $diretorio."/".$nomeArquivo;
            }

            $msgError = $this->validateMenuItem($register);
            if(!isset($msgError)){
                $register->save();

                \Session::flash('register', $register);

                $message = 'Menu item added successfully.';
                $typeMessage = 'green white-text';

                return redirect()->route('admin.menutype.menuitem', $menutype->id)
                    ->with(['message' => $message])
                    ->with(['typeMessage' => $typeMessage])
                    ->with(['previousPage', 'admin.menutype']);
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
            $register = MenuItem::find($id);
            
            \Session::flash('register', $register);

            return view('admin.menuitem.edit')
                ->with(['menutype' => $register->type])
                ->with(['previousPage' => 'admin.menutype.menuitem'])
                ->with(['parameterPreviousPage' => $register->type->id]);
        }else{
           return Util::redirectHome();
        }
    }

    public function update(Request $request, $id)
    {
        if(auth()->user()->can('menu_edit')){
            $data = $request->all();

            $register = MenuItem::find($id);
            $register->name = $data['name'];
            $register->description = $data['description'];
            $register->price = $data['price'];

            if($request->file('image-med')){
                $file = $request->file('image-med');
            }else if($request->file('image-mobile')){
                $file = $request->file('image-mobile');
            }else{
                $file = null;
            }

            if($file){
                $rand = rand(11111, 99999);
                $diretorio = "img/menu/".$register->type->name;
                $extensao = $file->guessClientExtension();
                $nomeArquivo = "_img_".str_slug($register->name, '_')."_".$rand.".".$extensao;
                $file->move($diretorio, $nomeArquivo);
                $register->image = $diretorio."/".$nomeArquivo;
            }

            $msgError = $this->validateMenuItem($register);
            if(!isset($msgError)){
                $register->save();

                \Session::flash('register', $register);

                $message = 'Menu item updated successfully.';
                $typeMessage = 'green white-text';

                return redirect()->route('admin.menutype.menuitem', $register->type->id)
                    ->with(['message' => $message])
                    ->with(['typeMessage' => $typeMessage])
                    ->with(['previousPage', 'admin.menutype']);
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

    public function delete($id)
    {
        if(auth()->user()->can('menu_delete')){
            $register = MenuItem::find($id);
            $register->deleted = true;
            $register->update();

            $message = 'Menu item deleted successfully.';
            $typeMessage = 'green white-text';

            return redirect()->route('admin.menutype.menuitem', $register->type->id)
                ->with( ['message' => $message] )
                ->with( ['typeMessage' => $typeMessage] );
        }else{
           return Util::redirectHome();
        }
    }

    //If there is not message error, it moves forward
    private function validateMenuItem($register)
    {
        if(!isset($register->name)){
            return 'Fields with * must be filled.';
        }else if(!isset($register->price)){
            return 'Fields with * must be filled.';
        }

        return null;
    }
}
