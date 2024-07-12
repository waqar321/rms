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
        Schema::create('ecom_order_journeys', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('merchant_id');
            $table->string('cn_number', 15);
            $table->dateTime('activity_date')->nullable();
            $table->unsignedBigInteger('status_id')->nullable();
            $table->string('status_code', 4);
            $table->string('reason', 255)->nullable();
            $table->string('receiver_name', 50)->nullable();
            $table->string('booked_packet_order_id', 50)->nullable();
            $table->text('custom_data')->nullable();
            $table->integer('attempt')->nullable();
            $table->tinyInteger('pushed')->default(0);
            $table->dateTime('pushed_at')->nullable();
            $table->unsignedBigInteger('client_response_code')->nullable();
            $table->longText('client_response')->nullable();
            $table->timestamps();
            $table->string('batch_id', 50)->nullable();
            $table->string('seller_id', 50)->nullable();
            $table->unsignedBigInteger('rawid')->nullable();
            $table->unsignedBigInteger('sqs_id')->nullable();
            $table->string('request_type', 1)->nullable();


            $table->index('cn_number');
            $table->index('merchant_id');
            $table->index('pushed');
            $table->index('batch_id');
            $table->index('seller_id');
            $table->index('rawid');
            $table->index('sqs_id');
            $table->index('created_at');
            $table->index(['updated_at', 'pushed', 'client_response_code']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ecom_order_journeys');
    }
};
