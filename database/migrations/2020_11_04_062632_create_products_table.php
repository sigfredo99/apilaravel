<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('product_id');
            $table->integer('category_id')->unsigned();
            $table->integer('restaurant_id')->unsigned();
            $table->string('code', 6)->unique();
            $table->string('name', 200);
            $table->text('description')->nullable();
            $table->decimal('price', 6, 2);
            $table->string('image', 200)->nullable();
            $table->unsignedInteger('status');
            $table->timestamps();
            $table->foreign('category_id')->references('category_id')->on('categories');
            $table->foreign('restaurant_id')->references('restaurant_id')->on('restaurants');
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
