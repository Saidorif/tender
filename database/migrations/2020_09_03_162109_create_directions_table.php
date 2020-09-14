<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDirectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('directions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('pass_number');
            $table->year('year');
            $table->string('distance');
            $table->bigInteger('type_id');
            $table->bigInteger('from_where');
            $table->string('seasonal');
            $table->bigInteger('region_from_id');
            $table->bigInteger('region_to_id');
            $table->bigInteger('area_from_id')->nullable();
            $table->bigInteger('area_to_id')->nullable();
            $table->bigInteger('station_from_id')->nullable();
            $table->bigInteger('station_to_id')->nullable();
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
        Schema::dropIfExists('directions');
    }
}
