<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationBallsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_balls', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->string('direction_ids');
            $table->string('company_name')->nullable();
            $table->string('name')->nullable();
            $table->integer('app_id');
            $table->integer('lot_id');
            $table->double('app_tarif',15,2)->nullable();
            $table->double('lot_tarif',15,2)->nullable();
            $table->double('tarif_ball',15,2)->nullable();
            $table->double('app_reys',15,2)->nullable();
            $table->double('lot_reys',15,2)->nullable();
            $table->double('reys_ball',15,2)->nullable();
            $table->double('app_years',15,2)->nullable();
            $table->double('lot_years',15,2)->nullable();
            $table->double('years_ball',15,2)->nullable();
            $table->double('app_capacity',15,2)->nullable();
            $table->double('lot_capacity',15,2)->nullable();
            $table->double('capacity_ball',15,2)->nullable();
            $table->string('app_categoryies')->nullable();
            $table->string('lot_categoryies')->nullable();
            $table->double('categoryies_ball',15,2)->nullable();
            $table->string('app_models')->nullable();
            $table->string('lot_models')->nullable();
            $table->double('models_ball',15,2)->nullable();
            $table->tinyInteger('daily_technical_job')->nullable();
            $table->tinyInteger('daily_medical_job')->nullable();
            $table->tinyInteger('hours_rule')->nullable();
            $table->tinyInteger('videoregistrator')->nullable();
            $table->tinyInteger('gps')->nullable();
            $table->double('cars_ball',15,2)->nullable();
            $table->double('total_ball',15,2)->nullable();
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
        Schema::dropIfExists('application_balls');
    }
}
