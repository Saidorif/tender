<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDirectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('directions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('titul_status')->default('active')->nullable();
            $table->integer('titul_approver')->nullable();
            $table->string('xronom_status')->default('active')->nullable();
            $table->integer('xronom_approver')->nullable();
            $table->string('name')->nullable();
            $table->string('pass_number');
            $table->string('from_type')->default('region');
            $table->string('to_type')->default('region');
            $table->date('year');
            $table->double('distance',15,2)->default(0)->nullable();
            $table->bigInteger('type_id');
            $table->text('from_where');
            $table->string('seasonal');
            $table->string('status')->default('active')->nullable();
            $table->string('profitability')->default('middle');//unprofitable,profitable,middle
            $table->bigInteger('region_from_id');
            $table->bigInteger('region_to_id');
            $table->bigInteger('area_from_id')->nullable();
            $table->bigInteger('area_to_id')->nullable();
            $table->bigInteger('station_from_id')->nullable();
            $table->bigInteger('station_to_id')->nullable();
            $table->bigInteger('created_by')->default(1)->nullable();
            $table->string('moderatory')->nullable();
            $table->string('dir_type');
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
        Schema::dropIfExists('directions');
    }
}
