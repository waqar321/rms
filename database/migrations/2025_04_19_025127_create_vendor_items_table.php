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
        Schema::create('vendor_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vendor_id');
            $table->string('item_name');
            $table->integer('quantity');
            $table->decimal('rate', 10, 2);
            $table->decimal('total_amount', 10, 2); // quantity * rate
            $table->date('purchase_date');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('vendor_id')->references('id')->on('users')->onDelete('cascade');
        });
            }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendor_items');
    }
};
