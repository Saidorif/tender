<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bus_models', function (Blueprint $table) {
            // $table->bigIncrements('id');
            // $table->bigInteger('busbrand_id');
            // $table->string('name');
            // $table->timestamps();
            $table->bigIncrements('id');
            $table->string('name');
            $table->bigInteger('bustype_id');
            $table->bigInteger('busmarka_id');
            $table->bigInteger('busmodel_id');
            $table->integer('seat_from');
            $table->integer('seat_to')->nullable();
            $table->text('desc')->nullable();
            $table->integer('stay_from');
            $table->integer('stay_to')->nullable();
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
        Schema::dropIfExists('bus_models');
    }
}
