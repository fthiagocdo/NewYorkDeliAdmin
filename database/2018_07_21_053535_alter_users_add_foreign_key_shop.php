<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUsersAddForeignKeyShop extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasColumn('users', 'preferred_shop')){
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('preferred_shop');
            });
        }

        if(!Schema::hasColumn('users', 'shop_id')){
            Schema::table('users', function (Blueprint $table) {
                $table->integer('shop_id')->unsigned()->nullable();
                $table->foreign('shop_id')->references('id')->on('shops');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
