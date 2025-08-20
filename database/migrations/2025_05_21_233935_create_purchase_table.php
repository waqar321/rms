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
        #php artisan migrate --path=database/migrations/2025_05_21_233935_create_purchase_table.php

        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->decimal('total_amount', 10, 2);
            $table->unsignedBigInteger('entry_by')->nullable();
            $table->foreign('entry_by')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('purchases');
    }
};
