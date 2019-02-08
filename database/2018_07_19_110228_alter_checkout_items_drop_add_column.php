<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCheckoutItemsDropAddColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasColumn('checkout_items', 'name')){
            Schema::table('checkout_items', function (Blueprint $table) {
                $table->dropColumn('name');
            });
        }

        if(!Schema::hasColumn('checkout_items', 'menuitem_id')){
            Schema::table('checkout_items', function (Blueprint $table) {
                $table->integer('menuitem_id')->unsigned();
                $table->foreign('menuitem_id')->references('id')->on('menu_items');
            });
        }

        if(!Schema::hasColumn('checkout_item_extras', 'name')){
            Schema::table('checkout_item_extras', function (Blueprint $table) {
                $table->dropColumn('name');
            });
        }

        if(!Schema::hasColumn('checkout_item_extras', 'menuextra_id')){
            Schema::table('checkout_item_extras', function (Blueprint $table) {
                $table->integer('menuextra_id')->unsigned();
                $table->foreign('menuextra_id')->references('id')->on('menu_extras');
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
