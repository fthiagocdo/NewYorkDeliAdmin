<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->string('description', 200)->nullable();
            $table->string('image', 200)->nullable();
            $table->double('price', 8, 2);
            $table->integer('menutype_id')->unsigned();
            $table->foreign('menutype_id')->references('id')->on('menu_types')->onDelete('cascade');
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
        //Schema::dropIfExists('menu_items');
    }
}
