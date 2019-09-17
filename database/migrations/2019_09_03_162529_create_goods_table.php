<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 128);
            $table->unsignedTinyInteger('type')->default(0);
            $table->integer('category_id')->default(0);
            $table->integer('gold_coin')->default(0)->comment('虚拟商品设置金币');
            $table->integer('mileage_coin')->default(0)->comment('虚拟商品设置里程币');
            $table->decimal('original_price')->default('0.00');
            $table->decimal('price')->default('0.00');
            $table->string('image')->nullable();
            $table->tinyInteger('applause_rate')->default(0);
            $table->unsignedInteger('stock')->default(0);
            $table->string('intro', 256)->nullable();
            $table->mediumText('details')->nullable();
            $table->unsignedTinyInteger('status')->default(0);
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
        Schema::dropIfExists('goods');
    }
}
