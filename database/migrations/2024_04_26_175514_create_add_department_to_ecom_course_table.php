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

        Schema::table('ecom_course', function (Blueprint $table) 
        {    
            $table->unsignedBigInteger('department_id');
            $table->unsignedBigInteger('sub_department_id');
            $table->foreign('department_id')->references('id')->on('ecom_department')->onDelete('cascade');
            $table->foreign('sub_department_id')->references('id')->on('ecom_department')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ecom_course', function (Blueprint $table) {
            $table->dropForeign(['department_id']);
            $table->dropForeign(['sub_department_id']);
            $table->dropColumn(['department_id', 'sub_department_id']);
        });
    }
};
