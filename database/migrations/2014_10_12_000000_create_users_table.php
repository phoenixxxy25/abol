<?php

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
            $table->increments('id');
            $table->integer('group')->default(0);
            $table->string('login')->unique();
            $table->string('full_name');
            $table->timestamp('birthday');
            $table->string('email')->unique();
            $table->string('address', 36);
            $table->string('city', 16);
            $table->string('state', 26);
            $table->string('country', 26);
            $table->string('zip', 16);
            $table->string('password', 60);
            $table->boolean('confirm_password')->default(false);
            $table->timestamps();
            $table->rememberToken();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
