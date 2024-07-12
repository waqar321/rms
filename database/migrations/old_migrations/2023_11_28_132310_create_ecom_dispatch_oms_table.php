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
        Schema::create('ecom_dispatch_oms', function (Blueprint $table) {
            $table->id();
            $table->string('CN_NUMBER')->nullable();
            $table->date('ISSUE_DATE')->nullable();
            $table->string('BOOK_TYPE_CODE', 25)->nullable();
            $table->string('ORIGON_CITY_ID',10)->nullable();
            $table->string('DEST_CITY_ID',10)->nullable();
            $table->string('STATUS_CODE',10)->nullable();
            $table->date('BOOK_DATE')->nullable();
            $table->string('BOOK_TIME', 15)->nullable();
            $table->string('UNIT_CODE', 10)->nullable();
            $table->decimal('WEIGHT', 10,2)->nullable();
            $table->decimal('NUMBER_PIECES', 5,0)->nullable();
            $table->decimal('AMNT',10,2)->nullable();
            $table->string('COUR_ID', 15)->nullable();
            $table->string('CLNT_ID',15)->nullable();
            $table->string('USER_ID', 11)->nullable();
            $table->string('REMARKS', 50)->nullable();
            $table->integer('cn_short')->nullable();
            $table->integer('Mail_NO')->unsigned()->nullable();
            $table->string('Cour_Name',50)->nullable();
            $table->string('heavy',1)->nullable();
            $table->string('byhand',1)->nullable();
            $table->string('van_no', 5)->nullable();
            $table->integer('cour_rcv_no')->unsigned()->nullable();
            $table->string('Station_id',10)->nullable();
            $table->string('pbag', 25)->nullable();
            $table->dateTime('SysDate_Time')->default(DB::raw('CURRENT_TIMESTAMP'))->onUpdate(DB::raw('CURRENT_TIMESTAMP'));
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
        Schema::dropIfExists('ecom_dispatch_oms');
    }
};
