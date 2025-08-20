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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., Chicken Roll, Zinger Burger
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('item_categories')->onDelete('cascade');
            $table->unsignedBigInteger('unit_type_id')->nullable();
            $table->foreign('unit_type_id')->references('id')->on('unit_types')->onDelete('cascade');
            $table->text('description')->nullable();
            $table->decimal('price', 8, 2); // current selling price
            $table->decimal('cost_price', 8, 2)->nullable(); // optional for profit calc
            $table->integer('stock_quantity')->nullable(); // optional if you track stock
            // $table->string('unit')->default('pcs'); // pcs, plate, bottle, etc.
            $table->boolean('is_available')->default(true); // show/hide in POS
            $table->integer('order')->default(0); // store image path if needed
            $table->string('image')->nullable(); // store image path if needed
            $table->string('image_path')->nullable(); // store image path if needed
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->boolean('is_pos_product')->default(true);
            $table->boolean('is_item_purchasing_product')->default(true);
            $table->boolean('is_active')->default(true);
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
        Schema::dropIfExists('items');
    }
};
