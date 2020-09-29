<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reys', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('direction_id');
            $table->integer('station_id');
            $table->integer('where_id');
            $table->integer('user_id')->nullable();
            $table->string('status')->default('active');
            $table->string('where_type')->default('region');
            $table->string('time_from_1')->nullable();
            $table->string('time_from_2')->nullable();
            $table->string('time_from_3')->nullable();
            $table->string('time_from_4')->nullable();
            $table->string('time_to_1')->nullable();
            $table->string('time_to_2')->nullable();
            $table->string('time_to_3')->nullable();
            $table->string('time_to_4')->nullable();
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
        Schema::dropIfExists('reys');
    }
}
