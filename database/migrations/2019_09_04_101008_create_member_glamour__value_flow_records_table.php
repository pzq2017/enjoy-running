<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberGlamourValueFlowRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_glamour_value_flow_records', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('uid');
            $table->integer('sender_id');
            $table->integer('receive_glamour_value')->default(0);
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
        Schema::dropIfExists('member_glamour_value_flow_records');
    }
}
