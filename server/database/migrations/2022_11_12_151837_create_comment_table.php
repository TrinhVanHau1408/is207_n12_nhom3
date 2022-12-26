<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comment', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customerId');
            $table->foreign('customerId')->references('id')->on('customer')->onDelete('cascade');
            $table->unsignedBigInteger('phoneId');
            $table->foreign('phoneId')->references('id')->on('phone')->onDelete('cascade');
            $table->text('content');
            $table->integer('like');
            $table->integer('dislike');
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
        Schema::dropIfExists('comment');
    }
}
