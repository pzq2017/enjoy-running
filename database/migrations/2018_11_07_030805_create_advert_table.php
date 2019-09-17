<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdvertTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advert', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('position_id');
            $table->string('name', 64)->nullable();
            $table->string('image_path', 128)->nullable();
            $table->string('url', 256)->nnullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('sort')->default(0);
            $table->dateTime('publish_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('advert');
    }
}
