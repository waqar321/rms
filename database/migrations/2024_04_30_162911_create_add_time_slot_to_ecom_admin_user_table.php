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
        Schema::table('ecom_admin_user', function (Blueprint $table) {
            $table->unsignedBigInteger('time_slot_id')->nullable()->after('shipper_id');
            $table->foreign('time_slot_id')->references('id')->on('ecom_employee_time_slots')->onDelete('cascade');    
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ecom_admin_user', function (Blueprint $table) {
            $table->dropForeign(['time_slot_id']);
        });
    }
};

