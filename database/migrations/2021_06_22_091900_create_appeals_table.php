<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appeals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('company_name')->nullable();
            $table->integer('user_id');
            $table->integer('contract_id');
            $table->string('type');
            $table->text('text')->nullable();
            $table->string('user_file');
            $table->dateTime('date');
            $table->string('answer_file')->nullable();
            $table->integer('approved_by')->nullable();
            $table->dateTime('approved_date')->nullable();
            $table->text('answer_text')->nullable();
            $table->integer('region_id')->nullable();
            $table->string('status')->default('pending');
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
        Schema::dropIfExists('appeals');
    }
}
