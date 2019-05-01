<?php

namespace App\Business;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use App\MenuType;
use App\MenuItem;

class MenuBusiness
{
	public static function findMenuTypes($preferredShop_id){
        $list = MenuType::where('shop_id', $preferredShop_id)
            ->orderBy('name', 'asc')
            ->get();

        if($list->count()){
            $return['error'] = false;
            $return['message'] = 'OK';
            $return['list'] = $list;
            return $return;
        }else{
            $return['error'] = true;
            $return['message'] = 'No records found.';
            $return['list'] = $list;
            return $return;
        } 
    }

    public static function findMenuItem($menutype_id){
        $list = MenuItem::where('menutype_id', $menutype_id)->get();
        
        if($list->count()){
            $return['error'] = false;
            $return['message'] = 'OK';
            $return['list'] = $list;
            return $return;
        }else{
            $return['error'] = true;
            $return['message'] = 'No records found.';
            $return['list'] = $list;
            return $return;
        } 
    }

    public static function findMenuExtra($menuitem_id){
        try{
            $menuItem = MenuItem::find($menuitem_id);
            $list = $menuItem->menuExtras;

            if($list->count()){
                $return['error'] = false;
                $return['message'] = 'OK';
                $return['list'] = $list;
                return $return;
            }else{
                $return['error'] = false;
                $return['message'] = 'No records found.';
                $return['list'] = $list;
                return $return;
            } 
        }catch(Exception $e){
            Log::error('MenuBusiness.findMenuExtra: '.$e->getMessage());
            $return['error'] = true;
            $return['message'] = 'It was no possible complete your request. Please try again later...';
            return $return;
        }
    }

    public static function getMenuItemImage($id)
    {
        $menuItem = MenuItem::find($id);
        $path = storage_path('app/public/menu/'.strtolower($menuItem->type->name).'.jpg');
        
        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }
}