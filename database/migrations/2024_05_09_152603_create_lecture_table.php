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
        Schema::create('ecom_lecture', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->integer('duration')->nullable();
            $table->string('local_video')->nullable();
            $table->string('url_video')->nullable();
            $table->string('local_document')->nullable();
            $table->string('url_document')->nullable();
            $table->string('Thumbnail')->nullable();
            $table->string('tags')->nullable();
            $table->string('Attachments')->nullable();
            $table->unsignedBigInteger('course_id')->nullable();
            $table->foreign('course_id')->references('id')->on('ecom_course')->onDelete('cascade');
            $table->unsignedBigInteger('instructor_id');
            $table->foreign('instructor_id')->references('id')->on('ecom_admin_user')->onDelete('cascade');
            $table->boolean('is_active')->default(1);
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
        Schema::dropIfExists('lecture');
    }
};
