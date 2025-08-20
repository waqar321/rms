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
        Schema::create('settings', function (Blueprint $table)
        {
            $table->id();
            // $table->string('details');
            $table->string('Brand_name')->nullable(); // store product logo
            $table->string('image')->nullable(); // store product logo
            $table->string('image_path')->nullable(); // store product logo
            $table->decimal('employee_discount', 10, 2);
            $table->time('shift_starting_time')->nullable();  // assuming only time is needed
            $table->time('shift_ending_time')->nullable();    // assuming only time is needed
            $table->longText('note_description')->nullable();    // assuming only time is needed
            $table->softDeletes();
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
        Schema::dropIfExists('settings');
    }
};
