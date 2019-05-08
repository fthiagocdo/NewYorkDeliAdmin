<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterMenuItemsTableAddColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('menu_items', 'deleted')){
            Schema::table('menu_items', function (Blueprint $table) {
                $table->boolean('deleted')->default(false);
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
        if(!Schema::hasColumn('menu_items', 'deleted')){
            Schema::table('menu_items', function (Blueprint $table) {
                $table->dropColumn('deleted');
            });
        }
    }
}
