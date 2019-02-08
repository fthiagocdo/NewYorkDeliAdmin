<?php

use Illuminate\Database\Seeder;
use App\User;

class RoleUserSeeds extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!User::where('email', '=', 'admin@mail.com')->first()->hasAdmin()){
        	User::where('email', '=', 'admin@mail.com')->first()->addRole('ADMIN');
        }
    }
}
