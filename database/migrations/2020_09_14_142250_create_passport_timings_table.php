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
            $table->double('start_speedometer',15,2);//Jonash vaqtida
            $table->double('end_speedometer',15,2);//Kelgan vaqtida
            $table->double('distance_from_start_station',15,2);//Boshlangich bekatdan
            $table->double('distance_between_station',15,2);//Bekatlar oraligida
            $table->double('distance_in_limited_speed',15,2);//Shundan xarakat tezligi chegaralangan oraliqda
            $table->double('spendtime_between_station',15,2);//Bekatlar oraligidagi xarakat
            $table->double('spendtime_between_limited_space',15,2);//Shundan xarakat tezligi chegaralangan oraliqda
            $table->double('spendtime_to_stay_station',15,2);//Oraliq bekatdan toxtash uchun
            $table->double('speed_between_station',15,2);//Bekatlar oraligidagi xarakat
            $table->double('speed_between_limited_space',15,2);//Shundan xarakat tezligi chegaralangan oraliqda
            $table->text('details');//Qatnov yoli xaqidagi malumotlar
            $table->text('whereForm')->nullable();
            $table->text('whereTo')->nullable();
            //$table->longText('vars')->nullable();
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
