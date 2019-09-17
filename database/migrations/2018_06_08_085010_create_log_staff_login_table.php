<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogStaffLoginTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_staff_login', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('staffId')->unsigned();
            $table->string('loginIp', 32);
            $table->timestamps();
            $table->index('staffId');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log_staff_login');
    }
}
