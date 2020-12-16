<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePassportTimingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('passport_timings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('direction_id');
            $table->bigInteger('region_from_id');
            $table->bigInteger('region_to_id');
            $table->bigInteger('area_from_id')->nullable();
            $table->bigInteger('area_to_id')->nullable();
            $table->bigInteger('station_from_id')->nullable();
            $table->bigInteger('station_to_id')->nullable();
            $table->dateTime('start_time');//Jonash vaqti
            $table->dateTime('end_time');//Kelgan vaqti
            $table->bigInteger('start_speedometer');//Jonash vaqtida
            $table->bigInteger('end_speedometer');//Kelgan vaqtida
            $table->bigInteger('distance_from_start_station');//Boshlangich bekatdan
            $table->bigInteger('distance_between_station');//Bekatlar oraligida
            $table->bigInteger('distance_in_limited_speed');//Shundan xarakat tezligi chegaralangan oraliqda
            $table->bigInteger('spendtime_between_station');//Bekatlar oraligidagi xarakat
            $table->bigInteger('spendtime_between_limited_space');//Shundan xarakat tezligi chegaralangan oraliqda
            $table->bigInteger('spendtime_to_stay_station');//Oraliq bekatdan toxtash uchun
            $table->bigInteger('speed_between_station');//Bekatlar oraligidagi xarakat
            $table->bigInteger('speed_between_limited_space');//Shundan xarakat tezligi chegaralangan oraliqda
            $table->text('details');//Qatnov yoli xaqidagi malumotlar
            $table->text('whereForm')->nullable();
            $table->text('whereTo')->nullable();
            $table->text('vars')->nullable();
            // $table->text('timingDetails')->nullable();
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
        Schema::dropIfExists('passport_timings');
    }
}
