<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDirectionReqsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('direction_reqs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('direction_id');
            $table->integer('auto_type')->nullable();
            $table->string('auto_type_name')->nullable();
            $table->string('auto_model_class')->nullable();
            $table->string('auto_trans_count')->nullable();
            $table->integer('auto_trans_count_from')->nullable();
            $table->integer('auto_trans_count_to')->nullable();
            $table->string('auto_trans_working_days')->nullable();
            $table->string('auto_trans_weekends')->nullable();
            $table->string('auto_trans_status')->nullable();
            $table->string('direction_total_length')->nullable();
            $table->string('direction_from_value')->nullable();
            $table->string('direction_from_name')->nullable();
            $table->string('direction_to_value')->nullable();
            $table->string('direction_to_name')->nullable();
            $table->string('stations_count')->nullable();
            $table->string('stations_from_name')->nullable();
            $table->string('stations_to_name')->nullable();
            $table->string('stations_from_value')->nullable();
            $table->string('stations_to_value')->nullable();
            $table->string('seasonal')->nullable();
            $table->string('reyses_count')->nullable();
            $table->string('reyses_from_value')->nullable();
            $table->string('reyses_from_name')->nullable();
            $table->string('reyses_to_value')->nullable();
            $table->string('reyses_to_name')->nullable();
            $table->string('schedule_begin_time')->nullable();
            $table->string('schedule_begin_from')->nullable();
            $table->string('schedule_begin_to')->nullable();
            $table->string('schedule_end_time')->nullable();
            $table->string('schedule_end_from')->nullable();
            $table->string('schedule_end_to')->nullable();
            $table->string('station_intervals')->nullable();
            $table->string('reys_time')->nullable();
            $table->string('reys_from_value')->nullable();
            $table->string('reys_to_value')->nullable();
            $table->string('schedules')->nullable();
            $table->string('tarif')->nullable();
            $table->string('tarif_one_km')->nullable();
            $table->string('tarif_full_km')->nullable();
            $table->string('tarif_full_km')->nullable();
            $table->string('tarif_city')->nullable();
            $table->string('transports_capacity')->nullable();
            $table->string('transports_seats')->nullable();
            $table->string('minimum_bal')->nullable();
            $table->string('status')->default('active')->nullable();
            $table->integer('approver')->nullable();
            $table->text('text')->nullable();
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
        Schema::dropIfExists('direction_reqs');
    }
}
