<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('order_id');
            $table->integer('customer_id')->unsigned();
            $table->integer('payment_method_id')->unsigned();
            $table->date('order_date');
            $table->time('order_hour');
            $table->string('cell_phone', 50);
            $table->string('address', 200);
            $table->string('reference', 200)->nullable();
            $table->decimal('subtotal', 6, 2);
            $table->decimal('igv', 6, 2);
            $table->decimal('total', 6, 2);
            $table->unsignedInteger('current_status');
            $table->unsignedInteger('payment_status');
            $table->unsignedInteger('billing_status');
            $table->unsignedInteger('sale_status');
            $table->unsignedInteger('command_status');
            $table->timestamps();
            $table->foreign('customer_id')->references('customer_id')->on('customers');
            $table->foreign('payment_method_id')->references('payment_method_id')->on('payment_methods');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
