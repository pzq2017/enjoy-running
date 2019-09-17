<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderInstitutionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_institution_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id');
            $table->integer('institution_id');
            $table->integer('institution_course_id');
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
        Schema::dropIfExists('order_institution_details');
    }
}
