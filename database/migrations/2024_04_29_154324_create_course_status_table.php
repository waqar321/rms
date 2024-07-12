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
        Schema::create('ecom_course_status', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_asigned_id');
            $table->foreign('course_asigned_id')->references('id')->on('ecom_course_assign')->onDelete('cascade');
            $table->enum('status', ['pending', 'completed'])->default('pending'); // Status to keep update
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
        Schema::dropIfExists('ecom_course_status');
    }
};
