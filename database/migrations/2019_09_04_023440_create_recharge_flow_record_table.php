<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRechargeFlowRecordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recharge_flow_record', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('uid');
            $table->string('flow_no', 32);
            $table->decimal('money')->default('0.00');
            $table->integer('gold_coin')->default(0);
            $table->unsignedTinyInteger('pay_type')->default(0);
            $table->decimal('pay_money')->default('0.00');
            $table->unsignedTinyInteger('pay_status')->default(0);
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
        Schema::dropIfExists('recharge_flow_record');
    }
}
