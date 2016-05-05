<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sale_detail_id')->unsigned();
            $table->foreign('sale_detail_id')->references('id')->on('sale_detail')->onUpdate('cascade')->onDelete('cascade');

            $table->string('item_code');
            $table->integer('qty');
            $table->double('rate');
            $table->string('remark');
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
        Schema::drop('sale');
    }
}
