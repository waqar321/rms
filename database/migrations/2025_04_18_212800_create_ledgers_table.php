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
        Schema::create('ledgers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('role_id')->nullable();
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('item_id')->nullable();
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');

            $table->tinyInteger('payment_type')->comment('1 = Cash, 2 = Buy, 3 = Sale');
            $table->integer('unit_qty');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('cash_amount', 10, 2);
            $table->decimal('total_amount', 10, 2);
            $table->decimal('remaining_amount', 10, 2)->nullable();
            $table->string('payment_detail');
            $table->boolean('is_paid')->default(false);
            $table->boolean('Ledger')->default(false);
            // $table->dateTime('entry_date');
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
        Schema::dropIfExists('ledgers');
    }
};
