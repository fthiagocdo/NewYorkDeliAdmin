<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolesSeeds extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!Role::where('name', '=', 'ADMIN')->count()){
        	$admin = Role::create([
        		'name'=>'ADMIN', 
        		'description'=>'System Administrator']);
        }

        if(!Role::where('name', '=', 'MANAGER')->count()){
        	$admin = Role::create([
        		'name'=>'MANAGER', 
        		'description'=>'Manager']);
        }

        if(!Role::where('name', '=', 'EMPLOYEE')->count()){
        	$admin = Role::create([
        		'name'=>'EMPLOYEE', 
        		'description'=>'Employee']);
        }

        if(!Role::where('name', '=', 'CUSTOMER')->count()){
        	$admin = Role::create([
        		'name'=>'CUSTOMER', 
        		'description'=>'Customer']);
        }
    }
}
