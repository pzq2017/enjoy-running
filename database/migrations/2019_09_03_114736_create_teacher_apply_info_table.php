<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeacherApplyInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teacher_apply_info', function (Blueprint $table) {
            $table->unsignedInteger('uid')->unique();
            $table->string('name', 32)->nullable();
            $table->unsignedTinyInteger('sex')->default(0);
            $table->string('phone', 32)->nullable();
            $table->string('id_card', 32)->nullable();
            $table->string('positive_id_card')->nullable();
            $table->string('side_id_card')->nullable();
            $table->decimal('private_tuition_fee', 10)->default('0.00');
            $table->decimal('group_buying_fee', 10)->default('0.00');
            $table->unsignedInteger('cluster_number')->default(0);
            $table->text('intro')->nullable();
            $table->text('course_details')->nullable();
            $table->string('detail_page_banner')->nullable();
            $table->string('achievement')->nullable();
            $table->string('motto')->nullable();
            $table->unsignedTinyInteger('audit_status')->default(0);
            $table->unsignedTinyInteger('pay_status')->default(0);
            $table->boolean('is_settled_success')->default(false);
            $table->text('audit_remark')->nullable();
            $table->boolean('is_recd')->default(false);
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
        Schema::dropIfExists('teacher_apply_info');
    }
}
