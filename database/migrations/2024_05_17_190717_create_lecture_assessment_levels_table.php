<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('lecture_assessment_levels', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lecture_id')->nullable();
            $table->foreign('lecture_id')->references('id')->on('ecom_lecture')->onDelete('cascade');
            $table->integer('assessment_level')->nullable();
            $table->integer('assessment_time')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        
        Schema::create('assessment_questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('assessment_id')->nullable();
            $table->foreign('assessment_id')->references('id')->on('lecture_assessment_levels')->onDelete('cascade');
            $table->unsignedBigInteger('question_id')->nullable();
            $table->foreign('question_id')->references('id')->on('lecture_questions')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('assessment_questions');
        Schema::dropIfExists('lecture_assessment_levels');
    }
};

