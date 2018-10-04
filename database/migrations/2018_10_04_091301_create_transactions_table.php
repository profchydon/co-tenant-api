<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('accepted_id')->unsigned();
            $table->string('amount')->nullable();
            $table->string('date')->nullable();
            $table->string('expiry_date')->nullable();
            $table->integer('count')->nullable();
            $table->timestamps();
        });

        Schema::table('transactions', function($table) {
          $table->foreign('accepted_id')->references('id')->on('accepted')->onDelete('cascade');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
