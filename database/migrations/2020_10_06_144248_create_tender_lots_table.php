<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenderLotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tender_lots', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('tender_id');
            $table->string('direction_id');
            $table->string('reys_id');
            $table->dateTime('time');
            $table->string('status');//custom|all
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
        Schema::dropIfExists('tender_lots');
    }
}
