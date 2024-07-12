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
        Schema::create('lecture_assessment_status', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lecture_id')->nullable();
            $table->foreign('lecture_id')->references('id')->on('ecom_lecture')->onDelete('cascade');
            $table->unsignedBigInteger('assessment_level')->nullable();
            // $table->foreign('assessment_level')->references('id')->on('lecture_assessment_levels')->onDelete('cascade');
            $table->unsignedBigInteger('question_level')->nullable();
            // $table->foreign('question_level')->references('id')->on('lecture_assessment_levels')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('ecom_admin_user')->onDelete('cascade');
            $table->boolean('status')->default(0);
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
        Schema::dropIfExists('lecture_assessment_status');
    }
};
