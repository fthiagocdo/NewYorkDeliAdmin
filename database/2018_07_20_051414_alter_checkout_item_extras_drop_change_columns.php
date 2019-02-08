<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCheckoutItemExtrasDropChangeColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasColumn('checkout_item_extras', 'name')){
            Schema::table('checkout_item_extras', function (Blueprint $table) {
                $table->dropColumn('name');
            });
        }

        if(Schema::hasColumn('checkout_item_extras', 'checkout_item_id')){
            Schema::table('checkout_item_extras', function (Blueprint $table) {
                $table->renameColumn('checkout_item_id', 'checkoutitem_id');
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
