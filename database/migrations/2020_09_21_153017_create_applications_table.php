<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id');
            $table->bigInteger('direction_id')->nullable();
            $table->bigInteger('tender_id')->nullable();
            $table->string('tarif')->nullable();
            $table->string('status')->default('active')->nullable();
            $table->string('daily_technical_job')->nullable();
            $table->string('daily_medical_job')->nullable();
            $table->string('30_hours_rule')->nullable();
            $table->string('videoregistrator')->nullable();
            $table->string('gps')->nullable();
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
        Schema::dropIfExists('applications');
    }
}
