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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Customer full name
            $table->string('phone')->nullable(); // Mobile number
            $table->string('email')->nullable(); // Optional email
            $table->string('address')->nullable(); // Delivery address
            $table->string('city')->nullable(); // City or region
            $table->string('cnic')->nullable(); // Optional CNIC
            $table->enum('gender', ['male', 'female', 'other'])->nullable(); // Optional gender
            $table->date('dob')->nullable(); // Date of birth
            $table->decimal('total_spent', 10, 2)->default(0); // Total money spent by customer
            $table->integer('visits')->default(0); // How many times visited
            $table->boolean('is_active')->default(true); // For soft-blocking
            $table->softDeletes(); // Soft delete support
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer');
    }
};
