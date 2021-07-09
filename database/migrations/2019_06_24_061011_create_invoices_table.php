<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('app_id');
            $table->integer('created_by')->default(2)->nullable();
            $table->integer('region_id');
            $table->integer('tender_id');
            $table->integer('lot_id');
            $table->string('status')->default('active');
            $table->string('number');
            $table->string('qrcode')->nullable();
            $table->string('text')->nullable();
            $table->string('inn')->nullable();
            $table->date('date');
            $table->double('price',15,2);
            $table->year('year')->default(date('Y'));
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
        Schema::dropIfExists('invoices');
    }
}
