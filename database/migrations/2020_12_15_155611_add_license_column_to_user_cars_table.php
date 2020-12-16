<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLicenseColumnToUserCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_cars', function (Blueprint $table) {
            $table->integer('license_status')->default(0)->nullable();
            $table->string('license_start_date')->nullable();
            $table->string('license_exp_date')->nullable();
            $table->string('license_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_cars', function (Blueprint $table) {
            //
        });
    }
}
