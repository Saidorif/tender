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
            $table->string('name');
            $table->string('surname');
            $table->string('middlename')->nullable();;
            $table->string('phone');
            $table->text('text');
            $table->string('file')->nullable();
            $table->string('status')->default('pending');
            $table->bigInteger('direction_id')->nullable();
            $table->bigInteger('category_id')->nullable();
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
