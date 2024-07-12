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
        Schema::create('ecom_course', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('sub_category_id');
            $table->unsignedBigInteger('instructor_id');
            // $table->unsignedBigInteger('department_id');
            // $table->unsignedBigInteger('sub_department_id');
            // $table->bigInteger('instructor_id')->unsigned();
            $table->integer('duration')->nullable();
            $table->string('level')->nullable();
            // $table->decimal('price', 10, 2)->nullable();
            $table->string('prerequisites')->nullable();
            $table->string('language')->nullable();
            $table->string('course_image')->nullable();
            $table->text('course_material')->nullable();
            $table->integer('enrollment_limit')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('course_format')->nullable();
            $table->string('course_code')->unique();
            // $table->enum('storage_type', ['local', 'url'])->nullable();
            // $table->string('local_video')->nullable();
            // $table->string('url_video')->nullable();
            // $table->string('local_document')->nullable();
            // $table->string('url_document')->nullable();
            // $table->string('tags')->nullable();
            $table->boolean('is_active')->default(1);
            $table->boolean('is_deleted')->default(0);
            $table->timestamps();
            
            // Foreign key constraints
            $table->foreign('category_id')->references('id')->on('ecom_category')->onDelete('cascade');
            $table->foreign('sub_category_id')->references('id')->on('ecom_category')->onDelete('cascade');
            // $table->foreign('department_id')->references('id')->on('ecom_department')->onDelete('cascade');
            // $table->foreign('sub_department_id')->references('id')->on('ecom_department')->onDelete('cascade');
            $table->foreign('instructor_id')->references('id')->on('ecom_admin_user')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ecom_course');
    }

    // public function up()
    // {
    //     Schema::create('ecom_category', function (Blueprint $table) {
    //         $table->id();
    //         $table->string('name');
    //         $table->unsignedBigInteger('parent_id')->nullable();
    //         $table->boolean('is_active')->default(1);
    //         $table->boolean('is_deleted')->default(0);
    //         $table->timestamps();
    //     });
    // }

    // /**
    //  * Reverse the migrations.
    //  *
    //  * @return void
    //  */
    // public function down()
    // {
    //     Schema::dropIfExists('ecom_category');
    // }

};
