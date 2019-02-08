<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersSeeds extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(User::where('email', '=', 'admin@mail.com')->count()){
            $usuario = User::where('email', '=', 'admin@mail.com')->first();
            $usuario->name = "System Administrator";
            $usuario->email = "admin@mail.com";
            $usuario->password = bcrypt("adm197569");
            $usuario->save();
        }else{
            $usuario = new User();
            $usuario->name = "System Administrator";
            $usuario->email = "admin@mail.com";
            $usuario->password = bcrypt("adm197569");
            $usuario->save();
        }
    }
}
