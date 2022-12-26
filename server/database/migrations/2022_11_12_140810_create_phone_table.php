<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhoneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phone', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->unsignedBigInteger('categoryId');
            $table->foreign('categoryId')->references('id')->on('category')->onDelete('cascade');
            $table->string('imgUrl');
            $table->decimal('priceSale', 15, 2);
            $table->text('description');
            $table->string('sim');
            $table->string('screen');
            $table->string('camera');
            $table->integer('ratingStart');
            $table->integer('viewCustomer');
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
        Schema::dropIfExists('phone');
    }
}
