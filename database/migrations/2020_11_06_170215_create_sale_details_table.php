<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaleDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_details', function (Blueprint $table) {
            $table->increments('sale_detail_id');
            $table->integer('sale_id')->unsigned();
            $table->char('item_code', 6);
            $table->string('item_description', 200);
            $table->unsignedInteger('quantity');
            $table->decimal('unit_value', 6, 2);
            $table->decimal('igv', 6, 2);
            $table->decimal('amount', 6, 2);
            $table->timestamps();
            $table->foreign('sale_id')->references('sale_id')->on('sales');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sale_details');
    }
}
