<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromotionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotion_details', function (Blueprint $table) {
            $table->increments('promotion_detail_id');
            $table->integer('promotion_id')->unsigned();
            $table->integer('restaurant_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->timestamps();
            $table->foreign('promotion_id')->references('promotion_id')->on('promotions');
            $table->foreign('restaurant_id')->references('restaurant_id')->on('restaurants');
            $table->foreign('product_id')->references('product_id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promotion_details');
    }
}
