<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_cars', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id');
            $table->bigInteger('app_id')->nullable();
            $table->bigInteger('tender_id')->nullable();
            $table->string('status')->default('active')->nullable();
            $table->string('auto_number')->nullable();
            $table->bigInteger('bustype_id')->nullable();
            $table->bigInteger('busmodel_id')->nullable();
            $table->bigInteger('busmarka_id')->nullable();
            $table->bigInteger('tclass_id')->nullable();
            $table->string('qty_reys')->nullable();
            $table->string('capacity')->nullable();
            $table->string('seat_qty')->nullable();
            $table->string('date')->nullable();
            $table->string('conditioner')->nullable();
            $table->string('internet')->nullable();
            $table->string('bio_toilet')->nullable();
            $table->string('bus_adapted')->nullable();
            $table->string('telephone_power')->nullable();
            $table->string('station_announce')->nullable();
            $table->string('monitor')->nullable();
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
        Schema::dropIfExists('user_cars');
    }
}
