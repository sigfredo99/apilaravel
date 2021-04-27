<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCorrelativesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('correlatives', function (Blueprint $table) {
            $table->increments('correlative_id');
            $table->string('invoice_serie',4);
            $table->unsignedInteger('invoice_correlative');
            $table->unsignedInteger('invoice_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('correlatives');
    }
}
