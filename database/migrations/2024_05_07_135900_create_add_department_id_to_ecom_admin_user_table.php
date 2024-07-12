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
        // Schema::create('add_department_id_to_ecom_admin_user', function (Blueprint $table) {
        //     $table->id();
        //     $table->timestamps();
        // });
        
        Schema::table('ecom_admin_user', function (Blueprint $table) {
            $table->string('zone')->after('branch_id');;
            $table->unsignedBigInteger('department_id')->nullable()->after('zone');
            $table->foreign('department_id')->references('id')->on('ecom_department')->onDelete('cascade');   //Assign to sub department
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
            $table->dropForeign(['department_id']);
        });

        // Schema::dropIfExists('add_department_id_to_ecom_admin_user');
    }
};
