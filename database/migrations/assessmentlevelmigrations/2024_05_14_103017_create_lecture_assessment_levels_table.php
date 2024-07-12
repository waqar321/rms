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
        Schema::create('lecture_assessment_levels', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lecture_id')->nullable();
            $table->foreign('lecture_id')->references('id')->on('ecom_lecture')->onDelete('cascade');
            $table->integer('assessment_level')->nullable();
            $table->integer('assessment_time')->nullable();
            $table->unsignedBigInteger('question_level')->nullable();
            $table->foreign('question_level')->references('question_level')->on('lecture_question_levels')->onDelete('cascade');           
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
        Schema::dropIfExists('lecture_assessment_levels');
    }
};
