<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('notification_id');
            $table->integer('customer_id')->unsigned();
            $table->integer('order_id')->unsigned();
            $table->string('message', 255);
            $table->unsignedInteger('status');
            $table->timestamps();
            $table->foreign('customer_id')->references('customer_id')->on('customers'); 
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
        Schema::dropIfExists('notifications');
    }
}
