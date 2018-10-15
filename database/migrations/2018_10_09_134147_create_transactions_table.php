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
          $table->integer('accept_id')->unsigned();
          $table->integer('cotenant_id')->unsigned();
          $table->string('email')->nullable();
          $table->string('amount')->nullable();
          $table->string('date_paid')->nullable();
          $table->string('date_of_next_payment')->nullable();
          $table->string('expiry_date')->nullable();
          $table->string('paystack_auth_code')->nullable();
          $table->integer('count')->nullable();
          $table->foreign('cotenant_id')->references('id')->on('cotenants')->onDelete('cascade');
          $table->foreign('accept_id')->references('id')->on('accepts')->onDelete('cascade');
          $table->foreign('email')->references('email')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('transactions');
    }
}
