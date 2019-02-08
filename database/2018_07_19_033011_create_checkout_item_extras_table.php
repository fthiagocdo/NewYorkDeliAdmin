<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCheckoutItemExtrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checkout_item_extras', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->double('price', 8, 2);
            $table->integer('checkout_item_id')->unsigned();
            $table->foreign('checkout_item_id')->references('id')->on('checkout_items')->onDelete('cascade');
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
        //Schema::dropIfExists('checkout_item_extras');
    }
}
