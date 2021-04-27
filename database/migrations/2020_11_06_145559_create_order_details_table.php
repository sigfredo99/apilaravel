<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->increments('order_detail_id');
            $table->integer('order_id')->unsigned();
            $table->string('item_code', 6);
            $table->string('item_description', 200);
            $table->unsignedInteger('quantity');
            $table->decimal('unit_price', 6, 2);
            $table->decimal('amount', 6, 2);
            $table->string('observation', 200)->nullable();
            $table->unsignedInteger('item_type');
            $table->timestamps();
            $table->foreign('order_id')->references('order_id')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_details');
    }
}
