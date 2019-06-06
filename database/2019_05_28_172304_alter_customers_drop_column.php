<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCustomersDropColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('customers');
        
        if (!Schema::hasTable('customers')) {
            Schema::create('customers', function (Blueprint $table) {
                $table->increments('id');
                $table->string('provider_id')->unique();
                $table->string('provider')->nullable(false);
                $table->boolean('receive_notifications')->default(true);
                $table->string('name')->nullable();
                $table->string('phone_number')->nullable();
                $table->string('postcode')->nullable();
                $table->string('address')->nullable();
                $table->timestamps();
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
        if (!Schema::hasTable('customers')) {
            Schema::create('customers', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->string('email');
                $table->string('provider_id')->unique();
                $table->string('profile_picture');
                $table->boolean('receive_notifications');
                $table->string('phone_number');
                $table->string('postcode');
                $table->string('address');
                $table->integer('shop_id')->unsigned()->nullable();
                $table->foreign('shop_id')->references('id')->on('shops');
                $table->timestamps();
            });
        }
    }
}
