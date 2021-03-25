<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_cars', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('auto_number');
            $table->integer('bustype_id');
            $table->integer('busmodel_id');
            $table->integer('tclass_id');
            $table->integer('busmarka_id');
            $table->integer('user_id');
            $table->integer('contract_id');
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
        Schema::dropIfExists('contract_cars');
    }
}
