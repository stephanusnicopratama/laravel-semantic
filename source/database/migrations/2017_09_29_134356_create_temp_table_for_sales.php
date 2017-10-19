<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTempTableForSales extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_temp', function (Blueprint $table){
           $table->increments('id');
           $table->string('transaction_code');
           $table->string('item_code');
           $table->integer('qty');
           $table->double('price');
           $table->string('user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('transaction_temp');
    }
}
