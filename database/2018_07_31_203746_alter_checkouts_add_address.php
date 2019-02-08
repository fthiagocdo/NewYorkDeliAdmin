<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCheckoutsAddAddress extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('checkouts', 'delivery_postcode')){
            Schema::table('checkouts', function (Blueprint $table) {
                $table->string('delivery_postcode')->nullable();
            });
        }

        if(!Schema::hasColumn('checkouts', 'delivery_address')){
            Schema::table('checkouts', function (Blueprint $table) {
                $table->string('delivery_address')->nullable();
            });
        }

        if(!Schema::hasColumn('checkouts', 'delivery_phone')){
            Schema::table('checkouts', function (Blueprint $table) {
                $table->string('delivery_phone')->nullable();
            });
        }

        if(!Schema::hasColumn('checkouts', 'printed')){
            Schema::table('checkouts', function (Blueprint $table) {
                $table->boolean('printed')->default(false);
            });
        }

        if(!Schema::hasColumn('checkouts', 'new_order')){
            Schema::table('checkouts', function (Blueprint $table) {
                $table->boolean('new_order')->default(false);
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
