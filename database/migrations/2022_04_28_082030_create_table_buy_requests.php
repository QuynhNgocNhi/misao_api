<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableBuyRequests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buy_requests', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('description')->nullable();
            $table->string('category_id')->nullable();
            $table->integer('quantity')->nullable();
            $table->unsignedBigInteger('user_id')->index();
            $table->string('unit')->nullable();
            $table->string('limited_date')->nullable();
            $table->integer('price')->default(0);
            $table->tinyInteger('is_active')->default(1)->index();
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
        Schema::dropIfExists('buy_requests');
    }
}
