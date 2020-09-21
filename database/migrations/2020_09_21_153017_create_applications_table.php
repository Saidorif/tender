<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id'),
            $table->string('auto_number'),
            $table->bigInteger('bustype_id'),
            $table->bigInteger('busmodel_id'),
            $table->bigInteger('tclass_id'),
            $table->string('seat_from'),
            $table->string('stay_count'),
            $table->string('tarif'),
            $table->string('estimated_time'),
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
        Schema::dropIfExists('applications');
    }
}
