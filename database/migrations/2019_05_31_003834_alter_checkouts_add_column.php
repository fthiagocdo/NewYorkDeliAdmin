<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCheckoutsAddColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('checkouts', 'delivery_name')){
            Schema::table('checkouts', function (Blueprint $table) {
                $table->string('delivery_name')->nullable();
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
        if(Schema::hasColumn('checkouts', 'delivery_name')){
            Schema::table('checkouts', function (Blueprint $table) {
                $table->dropColumn();
            });
        }
    }
}
