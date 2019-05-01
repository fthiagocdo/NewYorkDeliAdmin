<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //$this->call(UsersSeeds::class);
        //$this->call(RolesSeeds::class);
        //$this->call(RoleUserSeeds::class);
        //$this->call(PermissionsSeeds::class);
        $this->call(CountriesSeeder::class);
    }
}
