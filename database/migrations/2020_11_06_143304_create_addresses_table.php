<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->increments('address_id');
            $table->integer('customer_id')->unsigned();
            $table->integer('ubigeo_id')->unsigned();
            $table->string('address_type', 100);
            $table->string('address', 200);
            $table->string('reference', 200)->nullable();
            $table->unsignedInteger('status');
            $table->timestamps();
            $table->foreign('customer_id')->references('customer_id')->on('customers');
            $table->foreign('ubigeo_id')->references('ubigeo_id')->on('ubigeo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addresses');
    }
}
