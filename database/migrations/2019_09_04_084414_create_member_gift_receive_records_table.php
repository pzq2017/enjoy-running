<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberGiftReceiveRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_gift_receive_records', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('member_gift_id');
            $table->unsignedTinyInteger('receive_type')->default(0)->comment('自购/赠送');
            $table->integer('receive_id')->comment('自购放订单id，赠送放赠送用户id');
            $table->integer('receive_quantity')->default(0);
            $table->unsignedTinyInteger('status')->default(0);
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
        Schema::dropIfExists('member_gift_receive_records');
    }
}
