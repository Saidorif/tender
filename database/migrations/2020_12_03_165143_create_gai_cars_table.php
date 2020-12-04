<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGaiCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gai_cars', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_id');
            $table->string('app_id');
            $table->string('pTexpassportSery');
            $table->string('pTexpassportNumber');
            $table->string('pPlateNumber');
            $table->string("pVehicleId")->nullable();
            $table->string("pMarka")->nullable();
            $table->string("pMadeofYear")->nullable();
            $table->string("pNumberofplace")->nullable();
            $table->string("pWeightAuto")->nullable();
            $table->string("pNameOfClient")->nullable();
            $table->string("pTypeOfAuto")->nullable();
            $table->string("pTechnicalStatus")->nullable();
            $table->string("pAdressOfClient")->nullable();
            $table->string("status")->nullable();
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
        Schema::dropIfExists('gai_cars');
    }
}
