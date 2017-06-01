<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description');
            $table->integer('duration')->unsigned()->default(15);
            $table->string('url')->nullable();
            $table->boolean('active')->default(1);
            $table->tinyInteger('limit')->unsigned()->default(1);
            $table->tinyInteger('buffer_before')->unsigned()->default(0);
            $table->tinyInteger('buffer_after')->unsigned()->default(0);
            $table->boolean('is_payment_required')->default(0);
            $table->double('price')->default(0);
            $table->double('minimum_payment')->default(0);
            $table->text('image')->nullable();
            $table->integer('user_id')->unsigned();
            $table->integer('location_id')->unsigned()->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('location_id')->references('id')->on('locations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('services');
    }
}
