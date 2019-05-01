<?php

use Illuminate\Database\Seeder;
use App\Permission;

class PermissionsSeeds extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!Permission::where('name', '=', 'users_list')->count()){
        	$admin = Permission::create([
        		'name'=>'users_list', 
        		'description'=>'List Users']);
        }
        if(!Permission::where('name', '=', 'users_search')->count()){
        	$admin = Permission::create([
        		'name'=>'users_search', 
        		'description'=>'Search Users']);
        }
        if(!Permission::where('name', '=', 'user_edit')->count()){
        	$admin = Permission::create([
        		'name'=>'user_edit', 
        		'description'=>'Edit User']);
        }
        if(!Permission::where('name', '=', 'user_add')->count()){
            $admin = Permission::create([
                'name'=>'user_add', 
                'description'=>'Add Users']);
        }

        if(!Permission::where('name', '=', 'roles_list')->count()){
        	$admin = Permission::create([
        		'name'=>'roles_list', 
        		'description'=>'List Roles']);
        }
        if(!Permission::where('name', '=', 'role_add')->count()){
        	$admin = Permission::create([
        		'name'=>'role_add', 
        		'description'=>'Add Role']);
        }
        if(!Permission::where('name', '=', 'role_edit')->count()){
        	$admin = Permission::create([
        		'name'=>'role_edit', 
        		'description'=>'Edit Role']);
        }
        if(!Permission::where('name', '=', 'role_delete')->count()){
        	$admin = Permission::create([
        		'name'=>'role_delete', 
        		'description'=>'Delete Role']);
        }

        if(!Permission::where('name', '=', 'menu_list')->count()){
            $admin = Permission::create([
                'name'=>'menu_list', 
                'description'=>'List Menu']);
        }
        if(!Permission::where('name', '=', 'menu_add')->count()){
            $admin = Permission::create([
                'name'=>'menu_add', 
                'description'=>'Add Menu']);
        }
        if(!Permission::where('name', '=', 'menu_edit')->count()){
            $admin = Permission::create([
                'name'=>'menu_edit', 
                'description'=>'Edit Menu']);
        }
        if(!Permission::where('name', '=', 'menu_delete')->count()){
            $admin = Permission::create([
                'name'=>'menu_delete', 
                'description'=>'Delete Menu']);
        }

        if(!Permission::where('name', '=', 'shops_list')->count()){
            $admin = Permission::create([
                'name'=>'shops_list', 
                'description'=>'List Shops']);
        }
        if(!Permission::where('name', '=', 'shop_add')->count()){
            $admin = Permission::create([
                'name'=>'shop_add', 
                'description'=>'Add Shop']);
        }
        if(!Permission::where('name', '=', 'shop_edit')->count()){
            $admin = Permission::create([
                'name'=>'shop_edit', 
                'description'=>'Edit Shop']);
        }
        if(!Permission::where('name', '=', 'shop_delete')->count()){
            $admin = Permission::create([
                'name'=>'shop_delete', 
                'description'=>'Delete Shop']);
        }

        if(!Permission::where('name', '=', 'orders_list')->count()){
            $admin = Permission::create([
                'name'=>'orders_list', 
                'description'=>'List Orders']);
        }
        if(!Permission::where('name', '=', 'order_print')->count()){
            $admin = Permission::create([
                'name'=>'order_print', 
                'description'=>'Print Order']);
        }
    }
}
