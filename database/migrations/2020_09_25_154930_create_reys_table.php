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
            $table->text('where');//from|to
            $table->text('from');//from|to
            $table->text('stations');
            $table->string('type');
            $table->integer('count_bus');
            $table->integer('reys_from_count');
            $table->integer('reys_to_count');
            $table->integer('user_id')->nullable();
            $table->string('status')->default('active');
            $table->string('where_type')->default('region');
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
