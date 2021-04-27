<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOpinionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opinions', function (Blueprint $table) {
            $table->increments('opinion_id');
            $table->integer('customer_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->unsignedInteger('score');
            $table->text('comment')->nullable();
            $table->date('opinion_date');
            $table->timestamps();
            $table->foreign('customer_id')->references('customer_id')->on('customers');
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
        Schema::dropIfExists('opinions');
    }
}
