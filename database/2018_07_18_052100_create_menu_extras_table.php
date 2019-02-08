<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuExtrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_extras', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->double('price', 8, 2);
            $table->integer('menuitem_id')->unsigned();
            $table->foreign('menuitem_id')->references('id')->on('menu_items')->onDelete('cascade');
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
        //Schema::dropIfExists('menu_extras');
    }
}
