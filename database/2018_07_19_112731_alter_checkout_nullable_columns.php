<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCheckoutNullableColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasColumn('checkouts', 'partial_value')){
            Schema::table('checkouts', function (Blueprint $table) {
                $table->dropColumn('partial_value');
            });
        }

        if(!Schema::hasColumn('checkouts', 'partial_value')){
            Schema::table('checkouts', function (Blueprint $table) {
                $table->double('partial_value', 8, 2)->nullable();
            });
        }

        if(Schema::hasColumn('checkouts', 'delivery_fee')){
            Schema::table('checkouts', function (Blueprint $table) {
                $table->dropColumn('delivery_fee');
            });
        }

        if(!Schema::hasColumn('checkouts', 'delivery_fee')){
            Schema::table('checkouts', function (Blueprint $table) {
                $table->double('delivery_fee', 8, 2)->nullable();
            });
        }

        if(Schema::hasColumn('checkouts', 'rider_tip')){
            Schema::table('checkouts', function (Blueprint $table) {
                $table->dropColumn('rider_tip');
            });
        }

        if(!Schema::hasColumn('checkouts', 'rider_tip')){
            Schema::table('checkouts', function (Blueprint $table) {
                $table->double('rider_tip', 8, 2)->nullable();
            });
        }

        if(Schema::hasColumn('checkouts', 'total_value')){
            Schema::table('checkouts', function (Blueprint $table) {
                $table->dropColumn('total_value');
            });
        }

        if(!Schema::hasColumn('checkouts', 'total_value')){
            Schema::table('checkouts', function (Blueprint $table) {
                $table->double('total_value', 8, 2)->nullable();
            });
        }

        
        Schema::table('checkouts', function (Blueprint $table) {
            $table->integer('shop_id')->unsigned()->nullable()->change();
        });
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
