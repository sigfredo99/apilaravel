<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicingFileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoicing_file', function (Blueprint $table) {
            $table->increments('invoicing_file_id');
            $table->integer('sale_id')->unsigned();
            $table->string('xml_file', 200)->nullable();
            $table->string('cdr_file', 200)->nullable();
            $table->string('pdf_file', 200)->nullable();
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
        Schema::dropIfExists('invoicing_file');
    }
}
