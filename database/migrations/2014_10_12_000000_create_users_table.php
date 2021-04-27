<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('user_id');
            $table->string('name', 100);
            $table->string('last_name', 100);
            $table->string('cell_phone', 50)->nullable();
            $table->string('email', 100)->unique();
            $table->string('password');
            $table->rememberToken();
            $table->string('token_notification', 255)->nullable();
            $table->unsignedInteger('user_type');
            $table->unsignedInteger('status');
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
        Schema::dropIfExists('users');
    }
}
