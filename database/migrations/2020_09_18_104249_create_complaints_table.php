<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComplaintsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complaints', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigIncrements('name');
            $table->bigIncrements('surname');
            $table->bigIncrements('middlename')->nullable();;
            $table->bigIncrements('phone');
            $table->bigIncrements('text');
            $table->bigIncrements('file')->nullable();
            $table->string('status')->default('pending');
            $table->bigInteger('direction_id')->nullable();
            $table->integer('region_id')->nullable();
            $table->integer('area_id')->nullable();
            $table->bigInteger('user_id')->nullable();
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
        Schema::dropIfExists('complaints');
    }
}
