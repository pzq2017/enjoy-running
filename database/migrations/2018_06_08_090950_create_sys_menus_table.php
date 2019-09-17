<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSysMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_menus', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parentId')->unsigned()->default(0);
            $table->string('name', 64);
            $table->string('url', 64);
            $table->integer('sort')->default(0);
            $table->softDeletes();
            $table->timestamps();
            $table->index('parentId');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_menus');
    }
}
