<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('description')->nullable();
            $table->string('category_id')->nullable();
            $table->integer('inventory_number')->nullable();
            $table->unsignedBigInteger('user_id')->index();
            $table->string('unit')->nullable();
            $table->string('out_of_stock_date')->nullable();
            $table->integer('price')->default(0);
            $table->integer('discount')->default(0)->index();
            $table->tinyInteger('is_available')->default(0)->index();
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
        Schema::dropIfExists('products');
    }
}
