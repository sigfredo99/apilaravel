<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommandDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('command_details', function (Blueprint $table) {
            $table->increments('command_detail_id');
            $table->integer('command_id')->unsigned();
            $table->char('item_code', 6);
            $table->string('item_description', 200);
            $table->unsignedInteger('quantity');
            $table->string('observation', 200)->nullable();
            $table->string('promotion_parent', 200)->nullable();
            $table->timestamps();
            $table->foreign('command_id')->references('command_id')->on('command'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('command_details');
    }
}
