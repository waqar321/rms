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
        Schema::create('ecom_employee_time_slots', function (Blueprint $table) {
            $table->id();
            $table->string('shift_code');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('day_of_week');
            // $table->unsignedBigInteger('employee_id');
            // $table->foreign('employee_id')->references('id')->on('ecom_admin_user')->onDelete('cascade');     //Assign to employee
            $table->boolean('is_active')->default(1);
            $table->boolean('is_deleted')->default(0);
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
        Schema::dropIfExists('ecom_employee_time_slots');
    }
};
