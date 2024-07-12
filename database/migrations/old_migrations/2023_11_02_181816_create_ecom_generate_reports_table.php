<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ecom_generate_reports', function (Blueprint $table) {
            $table->id();
            $table->integer('generated_by');
            $table->string('report_type');
            $table->string('cn_type');
            $table->json('cns');
            $table->json('headers');
            $table->string('execution_time');
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
        Schema::dropIfExists('ecom_generate_reports');
    }
};
