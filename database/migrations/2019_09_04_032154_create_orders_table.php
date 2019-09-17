<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('uid');
            $table->char('no', 32);
            $table->unsignedTinyInteger('type');
            $table->unsignedTinyInteger('pay_way');
            $table->decimal('total_money')->default('0.00');
            $table->decimal('pay_money')->default('0.00');
            $table->integer('total_mileage_coin')->default(0);
            $table->integer('pay_mileage_coin')->default(0);
            $table->integer('total_gold_coin')->default(0);
            $table->integer('pay_gold_coin')->default(0);
            $table->boolean('is_pay_success')->default(false);
            $table->dateTime('pay_date')->nullable();
            $table->boolean('is_use_coupon')->default(false);
            $table->integer('coupon_id')->default(0);
            $table->integer('coupon_deduct')->default(0);
            $table->tinyInteger('status')->default(0);
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
        Schema::dropIfExists('orders');
    }
}
