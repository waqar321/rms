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
        Schema::create('ecom_course_content', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_id');
            // $table->string('title');
            // $table->text('description')->nullable();
            $table->string('local_video')->nullable();
            $table->string('url_video')->nullable();
            $table->string('local_document')->nullable();
            $table->string('url_document')->nullable();
            $table->foreign('course_id')->references('id')->on('ecom_course')->onDelete('cascade');
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
        Schema::dropIfExists('ecom_course_content');
    }
};
