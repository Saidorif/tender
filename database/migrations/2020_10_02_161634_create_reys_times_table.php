<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReysTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reys_times', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('reys_id');
            $table->bigInteger('direction_id')->nullable();
            $table->string('start');
            $table->string('end');
            $table->string('status')->default('active');
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
        Schema::dropIfExists('reys_times');
    }
}
