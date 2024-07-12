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
        Schema::table('ecom_arrival_oms', function (Blueprint $table) {
            $table->tinyInteger('is_push')->nullable()->default(0)->after('attempt_counter'); // Replace 'existing_column_name' with the actual column name after which you want to add the new column
        });
        Schema::table('ecom_dispatch_oms', function (Blueprint $table) {
            $table->tinyInteger('is_push')->nullable()->default(0)->after('SysDate_Time'); // Replace 'existing_column_name' with the actual column name after which you want to add the new column
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ecom_arrival_oms', function (Blueprint $table) {
            $table->dropColumn('is_push');
        });
        Schema::table('ecom_dispatch_oms', function (Blueprint $table) {
            $table->dropColumn('is_push');
        });
    }
};
