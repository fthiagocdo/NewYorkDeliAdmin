<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterShopsAddColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('shops', 'vendor_name')){
            Schema::table('shops', function (Blueprint $table) {
                $table->string('vendor_name')->nullable();
            });
        }

        if(!Schema::hasColumn('shops', 'integration_key')){
            Schema::table('shops', function (Blueprint $table) {
                $table->string('integration_key')->nullable();
            });
        }

        if(!Schema::hasColumn('shops', 'integration_password')){
            Schema::table('shops', function (Blueprint $table) {
                $table->string('integration_password')->nullable();
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
        if(Schema::hasColumn('shops', 'vendor_name')){
            Schema::table('shops', function (Blueprint $table) {
                $table->dropColumn('vendor_name');
            });
        }
        if(Schema::hasColumn('shops', 'integration_key')){
            Schema::table('shops', function (Blueprint $table) {
                $table->dropColumn('integration_key');
            });
        }
        if(Schema::hasColumn('shops', 'integration_password')){
            Schema::table('shops', function (Blueprint $table) {
                $table->dropColumn('integration_password');
            });
        }
    }
}
