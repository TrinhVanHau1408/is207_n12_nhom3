<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReplyCommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reply_comment', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('commentId');
            $table->foreign('commentId')->references('id')->on('comment')->onDelete('cascade');
            $table->unsignedBigInteger('customerId');
            $table->foreign('customerId')->references('id')->on('customer')->onDelete('cascade');
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
        Schema::dropIfExists('reply_comment');
    }
}
