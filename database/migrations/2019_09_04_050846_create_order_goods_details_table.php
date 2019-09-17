<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderGoodsDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_goods_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id');
            $table->integer('goods_id');
            $table->decimal('price')->default('0.00');
            $table->integer('mileage_coin')->default(0);
            $table->integer('gold_coin')->default(0);
            $table->integer('quantity')->default(0);
            $table->integer('color_id')->default(0);
            $table->integer('size_id')->default(0);
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
        Schema::dropIfExists('order_goods_details');
    }
}
