<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstitutionApplyInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('institution_apply_info', function (Blueprint $table) {
            $table->unsignedInteger('uid')->unique();
            $table->string('name', 32)->nullabnle();
            $table->string('phone', 32)->nullable();
            $table->string('id_card', 32)->nullable();
            $table->string('positive_id_card')->nullable();
            $table->string('side_id_card')->nullable();
            $table->string('business_license')->nullable();
            $table->string('province', 50)->nullable();
            $table->string('city', 50)->nullable();
            $table->string('region', 50)->nullable();
            $table->string('address')->nullable();
            $table->decimal('longitude', 10, 6)->nullable();
            $table->decimal('latitude', 10, 6)->nullable();
            $table->string('shop_name', 108)->nullable();
            $table->string('shop_logo')->nullable();
            $table->string('open_time', 20)->nullable();
            $table->string('close_time', 20)->nullable();
            $table->string('detail_page_banner')->nullable();
            $table->text('details')->nullable();
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
        Schema::dropIfExists('institution_apply_info');
    }
}
