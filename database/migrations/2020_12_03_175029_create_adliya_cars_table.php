<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdliyaCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adliya_cars', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger("user_id");
            $table->bigInteger("app_id");
            $table->string("pPinfl")->nullable();
            $table->string("pINN")->nullable();
            $table->string("nameOwner");
            $table->string("pKuzov");
            $table->string("pNumberNatarius");
            $table->string("pDateNatarius");
            $table->string("startDate");
            $table->string("expirationDate");
            $table->string("resultCode");
            $table->string("resultNote");
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
        Schema::dropIfExists('adliya_cars');
    }
}
