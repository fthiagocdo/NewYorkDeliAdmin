<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCheckoutsRenameColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasColumn('checkouts', 'user_id')){
            Schema::table('checkouts', function (Blueprint $table) {
                $table->renameColumn('user_id', 'customer_id');
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
        if(Schema::hasColumn('checkouts', 'customer_id')){
            Schema::table('checkouts', function (Blueprint $table) {
                $table->renameColumn('customer_id', 'user_id');
            });
        }
    }
}
