<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCotenantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('cotenants', function (Blueprint $table) {
        $table->increments('id');
        $table->integer('user_id')->unsigned();
        $table->string('co_gender')->nullable();
        $table->string('religion')->nullable();
        $table->string('co_religion')->nullable();
        $table->string('smoke')->nullable();
        $table->string('co_smoke')->nullable();
        $table->string('disabled')->nullable();
        $table->string('co_disabled')->nullable();
        $table->string('location_1')->nullable();
        $table->string('location_2')->nullable();
        $table->string('work')->nullable();
        $table->string('salary')->nullable();
        $table->string('rent')->nullable();
        $table->string('duration')->nullable();
        $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('cotenants');
    }
}
