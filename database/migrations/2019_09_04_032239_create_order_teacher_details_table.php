<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTeacherDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_teacher_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id');
            $table->integer('teacher_id');
            $table->string('field_ids', 30)->nullable();
            $table->unsignedTinyInteger('course_type')->default(0);
            $table->decimal('price')->default('0.00');
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
        Schema::dropIfExists('order_teacher_details');
    }
}
