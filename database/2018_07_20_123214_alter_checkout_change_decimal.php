<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCheckoutChangeDecimal extends Migration
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
                $table->double('partial_value', 8, 2)->change();
            });
        }

        if(Schema::hasColumn('checkouts', 'delivery_fee')){
            Schema::table('checkouts', function (Blueprint $table) {
                $table->double('delivery_fee', 8, 2)->change();
            });
        }

        if(Schema::hasColumn('checkouts', 'rider_tip')){
            Schema::table('checkouts', function (Blueprint $table) {
                $table->double('rider_tip', 8, 2)->change();
            });
        }

        if(Schema::hasColumn('checkouts', 'total_value')){
            Schema::table('checkouts', function (Blueprint $table) {
                $table->double('total_value', 8, 2)->change();
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
