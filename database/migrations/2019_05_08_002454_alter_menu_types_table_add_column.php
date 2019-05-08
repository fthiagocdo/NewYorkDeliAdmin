<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterMenuTypesTableAddColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('menu_types', 'deleted')){
            Schema::table('menu_types', function (Blueprint $table) {
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
        if(!Schema::hasColumn('menu_types', 'deleted')){
            Schema::table('menu_types', function (Blueprint $table) {
                $table->dropColumn('deleted');
            });
        }
    }
}
