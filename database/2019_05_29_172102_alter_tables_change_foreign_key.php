<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTablesChangeForeignKey extends Migration
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
                $table->dropColumn('user_id');
            });
        }
        if(Schema::hasColumn('checkouts', 'customer_id')){
            Schema::table('checkouts', function (Blueprint $table) {
                $table->dropColumn('customer_id');
            });
        }
        if(!Schema::hasColumn('checkouts', 'customer_id')){
            Schema::table('checkouts', function (Blueprint $table) {
                $table->integer('customer_id')->unsigned();
                $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
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
        if(!Schema::hasColumn('checkouts', 'user_id')){
            Schema::table('checkouts', function (Blueprint $table) {
                $table->integer('user_id')->unsigned();
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            });
        }
    }
}
