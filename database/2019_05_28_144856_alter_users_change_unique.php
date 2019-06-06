<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUsersChangeUnique extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasColumn('users', 'provider')){
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('provider');
            });
        }

        if(Schema::hasColumn('users', 'provider_id')){
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('provider_id');
            });
        }

        if(Schema::hasColumn('users', 'avatar')){
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('avatar');
            });
        }

        if(Schema::hasColumn('users', 'phone_number')){
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('phone_number');
            });
        }

        if(Schema::hasColumn('users', 'postcode')){
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('postcode');
            });
        }

        if(Schema::hasColumn('users', 'address')){
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('address');
            });
        }

        if(Schema::hasColumn('users', 'shop_id')){
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('shop_id');
            });
        }

        if(Schema::hasColumn('users', 'receive_notifications')){
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('receive_notifications');
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
        if(!Schema::hasColumn('users', 'provider')){
            Schema::table('users', function (Blueprint $table) {
                $table->string('provider')->nullable();
            });
        }

        if(!Schema::hasColumn('users', 'provider_id')){
            Schema::table('users', function (Blueprint $table) {
                $table->string('provider_id')->nullable();
            });
        }

        if(!Schema::hasColumn('users', 'avatar')){
            Schema::table('users', function (Blueprint $table) {
                $table->text('avatar')->nullable();
            });
        }

        if(!Schema::hasColumn('users', 'phone_number')){
            Schema::table('users', function (Blueprint $table) {
                $table->string('phone_number')->nullable();
            });
        }

        if(!Schema::hasColumn('users', 'postcode')){
            Schema::table('users', function (Blueprint $table) {
                $table->string('postcode')->nullable();
            });
        }

        if(!Schema::hasColumn('users', 'address')){
            Schema::table('users', function (Blueprint $table) {
                $table->string('address')->nullable();
            });
        }

        if(!Schema::hasColumn('users', 'shop_id')){
            Schema::table('users', function (Blueprint $table) {
                $table->integer('shop_id')->unsigned()->nullable();
                $table->foreign('shop_id')->references('id')->on('shops');
            });
        }

        if(!Schema::hasColumn('users', 'receive_notifications')){
            Schema::table('users', function (Blueprint $table) {
                $table->enum('receive_notifications', ['yes', 'no'])->default('no');
            });
        }
    }
}
