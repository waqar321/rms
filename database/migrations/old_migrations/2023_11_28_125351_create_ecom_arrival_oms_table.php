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
        Schema::create('ecom_arrival_oms', function (Blueprint $table) {
            $table->id();
            $table->string('CN_NUMBER')->nullable();
            $table->date('ARVL_DATE')->nullable();
            $table->string('ARVL_TIME', 10)->nullable();
            $table->string('Arvl_Origin',10)->nullable();
            $table->string('ARVL_VIA',10)->nullable();
            $table->string('ARVL_ZONE',10)->nullable();
            $table->string('ARVL_DEST',10)->nullable();
            $table->string('CN_TYPE', 1)->nullable();
            $table->decimal('PCS', 5,0)->nullable();
            $table->decimal('WEIGHT', 10,2)->nullable();
            $table->string('STATUS', 25)->nullable();
            $table->string('REMARKS',100)->nullable();
            $table->string('SHART_CN', 15)->nullable();
            $table->string('USER_ID', 11)->nullable();
            $table->string('COURIER_ID',15)->nullable();
            $table->date('COUR_DATE')->nullable();
            $table->string('Cour_Time', 15)->nullable();
            $table->string('BH_REMARKS', 15)->nullable();
            $table->text('REASON')->nullable();
            $table->string('RECEIVER_NAME', 50)->nullable();
            $table->date('ACTIVITY_DATE')->nullable();
            $table->string('ACTIVITY_TIME', 15)->nullable();
            $table->date('DELIVERY_DATE')->nullable();
            $table->string('DELIVERY_TIME',15)->nullable();
            $table->string('Cour_Name',50)->nullable();
            $table->string('cnic_no', 25)->nullable();
//            $table->double('id')->nullable();
            $table->dateTime('SysDate_Time')->default(DB::raw('CURRENT_TIMESTAMP'))->onUpdate(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('group_status_code', 255)->nullable();
            $table->string('child_status_code', 255)->nullable();
            $table->string('robo_resp', 255)->nullable();
            $table->string('matech_resp', 255)->nullable();
            $table->integer('attempt_counter')->default(0)->nullable();
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
        Schema::dropIfExists('ecom_arrival_oms');
    }
};
