<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInterestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interests', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('property_id')->unsigned();
          $table->integer('cotenant_id')->unsigned();
          $table->foreign('cotenant_id')->references('id')->on('cotenants')->onDelete('cascade');
          $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
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
        Schema::dropIfExists('interests');
    }
}
