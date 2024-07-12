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
        Schema::create('ecom_course_assign', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_id')->nullable();
            $table->foreign('course_id')->references('id')->on('ecom_course')->onDelete('cascade');
            $table->unsignedBigInteger('user_uploader_id')->nullable();
            $table->foreign('user_uploader_id')->references('id')->on('ecom_admin_user')->onDelete('cascade');       //uploaded by user 
            $table->unsignedBigInteger('instructor_id')->nullable();
            $table->foreign('instructor_id')->references('id')->on('ecom_admin_user')->onDelete('cascade');   //uploaded by user 
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->foreign('employee_id')->references('id')->on('ecom_admin_user')->onDelete('cascade');     //Assign to employee
            $table->unsignedBigInteger('department_id')->nullable();
            $table->foreign('department_id')->references('id')->on('ecom_department')->onDelete('cascade');   //Assign to sub department
            $table->unsignedBigInteger('sub_department_id')->nullable();
            $table->foreign('sub_department_id')->references('id')->on('ecom_department')->onDelete('cascade');   //Assign to sub department
            $table->string('zone_code')->nullable();
            $table->foreign('zone_code')->references('zone_code')->on('zone')->onDelete('cascade');   //Assign to Zone
            $table->unsignedInteger('city_id')->nullable();                                                           // integer() || unsignedInteger();
            $table->foreign('city_id')->references('city_id')->on('central_ops_city')->onDelete('cascade');   //Assign to Zone
            $table->Integer('branch_id')->nullable();
            $table->foreign('branch_id')->references('branch_id')->on('central_ops_branch')->onDelete('cascade');  //Branch/Location
            $table->unsignedBigInteger('role_id')->nullable();
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');            //Role Wise assign
            $table->unsignedBigInteger('shift_time_id')->nullable();
            $table->foreign('shift_time_id')->references('id')->on('ecom_employee_time_slots')->onDelete('cascade');   //Branch/Location
            $table->string('upload_csv')->nullable();                                                                         // upload CSV file so that we can iterate through employee's id and send certificate to those employee's who has complete their course 
            $table->json('upload_csv_json_data')->nullable();                                                                         // upload CSV file so that we can iterate through employee's id and send certificate to those employee's who has complete their course 
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
        // Schema::table('central_ops_branch', function (Blueprint $table) {
        //     $table->dropIndex(['branch_id']);
        // });

        Schema::dropIfExists('course_asign');
    }
};
