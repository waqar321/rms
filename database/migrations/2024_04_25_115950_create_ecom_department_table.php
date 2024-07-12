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
        Schema::create('ecom_department', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Department Name
            // $table->string('code'); // Department Code
            // $table->string('hod'); // Head of Department (HOD)
            $table->text('description'); // Description
            $table->string('office_location'); // Office Location
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('ecom_department')->onDelete('cascade');
            $table->boolean('is_active')->default(1);
            // $table->boolean('is_deleted')->default(0);
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
        Schema::dropIfExists('ecom_department');
    }
};
