<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAcceptedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accepted', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('property_id')->unsigned();
          $table->integer('cotenant_id')->unsigned();
          $table->string('amount')->nullable();
          $table->string('date_initiated')->nullable();
          $table->string('date_paid')->nullable();
          $table->string('status')->nullable();
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
        Schema::dropIfExists('accepted');
    }
}
