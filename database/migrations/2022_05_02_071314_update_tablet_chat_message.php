<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTabletChatMessage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('chat_room_id')->index();
            $table->unsignedBigInteger('buyer_id')->nullable()->index();
            $table->unsignedBigInteger('seller_id')->nullable()->index();
            $table->text('content');
            $table->integer('type')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chat_messages');
    }
}
