<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberMileageCoinFlowRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_mileage_coin_flow_records', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('uid');
            $table->unsignedTinyInteger('flow_type')->default(0);
            $table->integer('mileage_coin')->default(0);
            $table->string('remark')->nullable();
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
        Schema::dropIfExists('member_mileage_coin_flow_records');
    }
}
