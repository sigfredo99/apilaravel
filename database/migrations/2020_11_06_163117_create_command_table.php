<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommandTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('command', function (Blueprint $table) {
            $table->increments('command_id');
            $table->integer('order_id')->unsigned();
            $table->integer('restaurant_id')->unsigned();
            $table->date('command_date');
            $table->time('command_hour');
            $table->unsignedInteger('status');
            $table->timestamps();
            $table->foreign('order_id')->references('order_id')->on('orders');
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
        Schema::dropIfExists('command');
    }
}
