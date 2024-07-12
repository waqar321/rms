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
        if (!Schema::hasTable('ecom_merchant_roles')) {
            Schema::create('ecom_merchant_roles', function (Blueprint $table) {
                $table->id();
                $table->string('role_name', 150);
                $table->integer('admin_user_id')->nullable()->index('admin_user_id');
                $table->integer('is_deleted')->default(0)->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ecom_merchant_roles');
    }
};
