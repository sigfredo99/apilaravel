<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillingDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billing_data', function (Blueprint $table) {
            $table->increments('billing_data_id');
            $table->integer('order_id')->unsigned();
            $table->char('invoice_type', 2);
            $table->char('document_type', 2);
            $table->string('document_number', 11);
            $table->string('denomination', 200);
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
        Schema::dropIfExists('billing_data');
    }
}
