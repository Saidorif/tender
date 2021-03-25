<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->integer('created_by');
            $table->integer('app_id')->nullable();
            $table->integer('app_ball_id')->nullable();
            $table->integer('tender_id')->nullable();
            $table->integer('lot_id')->nullable();
            $table->string('type')->default('new');
            $table->string('number');
            $table->date('date');
            $table->date('exp_date');
            $table->tinyInteger('contract_period');
            $table->integer('region_id');
            $table->string('direction_ids');
            $table->integer('protocol_id');
            $table->string('file');
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
        Schema::dropIfExists('contracts');
    }
}
