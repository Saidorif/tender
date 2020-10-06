<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimingDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timing_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('direction_id');
            $table->date('date');
            $table->string('avto_number');
            $table->string('avto_model');
            $table->string('conclusion');
            $table->string('technic_speed');
            $table->string('traffic_speed');
            $table->text('persons');
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
        Schema::dropIfExists('timing_details');
    }
}
