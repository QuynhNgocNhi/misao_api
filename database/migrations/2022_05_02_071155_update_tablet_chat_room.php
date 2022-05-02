<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTabletChatRoom extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_rooms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('buyer_id')->index();
            $table->unsignedBigInteger('seller_id')->index();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('buy_request_id')->nullable();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->timestamp('buyer_read_at')->nullable();
            $table->timestamp('seller_read_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chat_rooms');
    }
}
