<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_status', function (Blueprint $table) {
            $table->increments('order_status_id');
            $table->integer('order_id')->unsigned();
            $table->unsignedInteger('status');
            $table->date('order_date');
            $table->time('order_hour');
            $table->string('reason', 200)->nullable();
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
        Schema::dropIfExists('order_status');
    }
}
