<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('surname')->nullable();
            $table->string('middlename')->nullable();
            $table->date('position_date')->nullable();
            $table->integer('region_id');
            $table->integer('area_id');
            $table->integer('position_id')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('license_number')->nullable();
            $table->string('license_date')->nullable();
            $table->string('license_type')->nullable();
            $table->unsignedBigInteger('role_id');
            $table->text('image')->nullable();
            $table->string('city')->nullable();
            $table->string('phone')->nullable();
            $table->string('bank_number')->nullable();
            $table->string('oked')->nullable();
            $table->string('inn')->nullable()->unique();
            $table->string('mfo')->nullable();
            $table->string('address')->nullable();
            $table->string('company_name')->nullable();
            $table->double('balance',15,2)->default(0);
            $table->string('trusted_person')->nullable();
            $table->string('status')->default('active');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
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
        Schema::dropIfExists('users');
    }
}
