<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member', function (Blueprint $table) {
            $table->increments('id');
            $table->string('loginAccount', 32)->unique();
            $table->string('loginPwd', 64);
            $table->string('nickname', 64)->nullable();
            $table->string('avatar', 108)->nullable();
            $table->unsignedTinyInteger('sex')->default(0);
            $table->string('birthday', 16)->nullable();
            $table->string('mobile', 11);
            $table->string('signature')->nullable();
            $table->unsignedInteger('glamour_value')->default(0)->comment('魅力值');
            $table->unsignedInteger('mileage_coin')->default(0)->comment('里程币');
            $table->unsignedInteger('gold_coin')->default(0)->comment('金币');
            $table->decimal('balance_money')->default('0.00')->comment('账户余额');
            $table->unsignedTinyInteger('status')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->index(['loginAccount', 'loginPwd']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('member');
    }
}
