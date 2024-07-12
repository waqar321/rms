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
//        Schema::create('ecom_admin_user_city_rights', function (Blueprint $table) {
//            $table->id();
//            $table->integer('admin_user_id');
//            $table->integer('city_id');
//            $table->boolean('is_deleted')->default(0);
//            $table->timestamps();
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ecom_admin_user_city_rights');
    }
};
