<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->increments('sale_id');
            $table->integer('customer_id')->unsigned();
            $table->integer('order_id')->unsigned();
            $table->date('sale_date');
            $table->time('sale_hour');
            $table->char('invoice_type', 2);
            $table->char('invoice_serie', 4);
            $table->string('invoice_number', 8);
            $table->string('address', 200);
            $table->decimal('subtotal', 6, 2);
            $table->decimal('igv', 6, 2);
            $table->decimal('total', 6, 2);
            $table->char('document_type', 2);
            $table->string('document_number', 11);
            $table->string('denomination', 200);
            $table->unsignedInteger('billing_file');
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
        Schema::dropIfExists('sales');
    }
}
