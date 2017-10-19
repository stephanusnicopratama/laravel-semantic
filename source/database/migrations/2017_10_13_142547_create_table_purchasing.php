<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePurchasing extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchasing', function (Blueprint $table){
            $table->increments('id');
            $table->integer('qty');
            $table->integer('price');
            $table->text('notes');
            $table->date('date');
            $table->string('item_code');
            $table->integer('id_supplier');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('purchasing');
    }
}
