<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDirectionCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('direction_cars', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('direction_id');
            $table->bigInteger('busmarka_id')->nullable();
            $table->bigInteger('busmodel_id')->nullable();
            $table->bigInteger('bustype_id');
            $table->bigInteger('tclass_id');
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
        Schema::dropIfExists('direction_cars');
    }
}
