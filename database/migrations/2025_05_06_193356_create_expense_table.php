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
        Schema::create('expenses', function (Blueprint $table)
        {
            $table->id();
            // add expenses fields
            $table->unsignedBigInteger('user_id')->nullable(); // Who recorded the expense
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->unsignedBigInteger('item_id')->nullable(); // Who recorded the expense
            $table->foreign('item_id')->references('id')->on('expense_list')->onDelete('set null');

            $table->string('category')->nullable(); // Category of expense (e.g., travel, food)
            $table->string('description')->nullable(); // Description of the expense
            $table->decimal('amount', 10, 2); // Amount spent
            $table->date('expense_date'); // Date of expense
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
        Schema::dropIfExists('expenses');
    }
};
