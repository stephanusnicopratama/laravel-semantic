<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Items extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->string('item_code');
            $table->string('item_name');
            $table->integer('item_stock');
            $table->integer('item_type');
            $table->string('piece');
            $table->string('user');
            $table->double('selling_price');
            $table->double('purchase_price');
            $table->string('supplier');
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('items');
    }
}
