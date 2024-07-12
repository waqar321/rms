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
          
        Schema::table('ecom_lecture', function (Blueprint $table) 
        {
            $table->string('passing_ratio')->after('course_id');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ecom_lecture', function (Blueprint $table) {
            $table->dropColumn('passing_ratio');
        });
    }
};
