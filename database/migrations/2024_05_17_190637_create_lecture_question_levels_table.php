<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('lecture_question_levels', function (Blueprint $table) {
            $table->id();
            $table->string('level_name')->nullable()->index();
            $table->timestamps();
        });
        
        Schema::create('lecture_questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('question_level_id')->nullable()->index();
            $table->foreign('question_level_id')->references('id')->on('lecture_question_levels')->onDelete('cascade');
            $table->string('question')->nullable();
            $table->string('answer')->nullable();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('lecture_questions');
        Schema::dropIfExists('lecture_question_levels');
    }
};
