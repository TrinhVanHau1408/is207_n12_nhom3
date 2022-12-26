<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressReceiveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('address_receive', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customerId');
            $table->foreign('customerId')->references('id')->on('customer')->onDelete('cascade');
            $table->string('nameReceiver');
            $table->string('numberPhoneReceiver');
            $table->string('addressReceiver');
            $table->string('numberApartment');
            $table->integer('defaultAddress');
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
        Schema::dropIfExists('address_receive');
    }
}
