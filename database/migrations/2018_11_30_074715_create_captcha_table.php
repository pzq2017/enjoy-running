<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCaptchaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('captcha', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mobile', 16)->nullable();
            $table->string('code', 16)->nullable();
            $table->string('ip', 20)->nullable();
            $table->unsignedTinyInteger('type')->default(0);
            $table->boolean('status')->default(false);
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
        Schema::dropIfExists('captcha');
    }
}
