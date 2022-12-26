<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CratePhoneDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phone_detail', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->unsignedBigInteger('phoneId');
            $table->foreign('phoneId')->references('id')->on('phone')->onDelete('cascade');
            $table->String('imgUrl');
            $table->unsignedBigInteger('ramId');
            $table->foreign('ramId')->references('id')->on('ram')->onDelete('cascade');
            $table->unsignedBigInteger('romId');
            $table->foreign('romId')->references('id')->on('rom')->onDelete('cascade');
            $table->unsignedBigInteger('colorId');
            $table->foreign('colorId')->references('id')->on('color')->onDelete('cascade');
            $table->integer('quantity');
            $table->integer('percentPrice');
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
        //
    }
}
