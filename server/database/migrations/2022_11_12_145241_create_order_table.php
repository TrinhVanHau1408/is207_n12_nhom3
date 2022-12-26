<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customerId');
            $table->foreign('customerId')->references('id')->on('customer')->onDelete('cascade');
            $table->text('orderCode');
            $table->unsignedBigInteger('paymentId');
            $table->foreign('paymentId')->references('id')->on('payment_method');
            $table->unsignedBigInteger('shipId');
            $table->foreign('shipId')->references('id')->on('ship_method')->onDelete('cascade');
            $table->unsignedBigInteger('addressReceiveId');
            $table->foreign('addressReceiveId')->references('id')->on('address_receive')->onDelete('cascade');
            $table->unsignedBigInteger('statusId');
            $table->foreign('statusId')->references('id')->on('status')->onDelete('cascade');
            $table->text('noteMess');
            $table->softDeletes();
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
        Schema::dropIfExists('order');
    }
}
