<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCheckoutItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checkout_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('checkout_id')->unsigned();
            $table->foreign('checkout_id')->references('id')->on('checkouts')->onDelete('cascade');
            $table->string('name', 100);
            $table->double('unitary_price', 8, 2);
            $table->integer('quantity')->unsigned();
            $table->double('total_price', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Schema::dropIfExists('checkout_items');
    }
}
