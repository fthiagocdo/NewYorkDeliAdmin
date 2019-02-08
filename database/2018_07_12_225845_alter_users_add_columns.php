<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUsersAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
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

        if(!Schema::hasColumn('users', 'nu_error_login')){
            Schema::table('users', function (Blueprint $table) {
                $table->integer('nu_error_login')->unsigned()->default(0);
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

        if(!Schema::hasColumn('users', 'preferred_shop')){
            Schema::table('users', function (Blueprint $table) {
                $table->enum('preferred_shop', ['aylesbury', 'maidenhead'])->default('aylesbury');
            });
        }

        if(!Schema::hasColumn('users', 'receive_notifications')){
            Schema::table('users', function (Blueprint $table) {
                $table->enum('receive_notifications', ['yes', 'no'])->default('no');
            });
        }

        Schema::table('users', function (Blueprint $table) {
            $table->string('password')->nullable()->change();
        });
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
