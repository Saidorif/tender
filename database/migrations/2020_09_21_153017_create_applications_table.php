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
            $table->string('direction_ids')->nullable();
            $table->bigInteger('tender_id')->nullable();
            $table->bigInteger('lot_id');
            $table->string('tarif')->nullable();
            $table->string('status')->default('active')->nullable();
            $table->string('tender_status')->default('active')->nullable();
            $table->string('daily_technical_job')->nullable();
            $table->string('daily_medical_job')->nullable();
            $table->string('hours_rule')->nullable();
            $table->string('videoregistrator')->nullable();
            $table->string('gps')->nullable();
            $table->string('qr_code')->nullable();
            $table->tinyInteger('contract_time')->nullable();
            $table->double('total_ball',15,2)->default(0);
            $table->tinyInteger('daily_technical_job_status')->nullable();
            $table->tinyInteger('daily_medical_job_status')->nullable();
            $table->tinyInteger('hours_rule_status')->nullable();
            $table->tinyInteger('videoregistrator_status')->nullable();
            $table->tinyInteger('gps_status')->nullable();
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
