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
    public function up() {
        Schema::create('users', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name',80);
            $table->string('last',80);
            $table->string('email',200)->unique();
            $table->string('password');
            $table->integer('type_user_id')->unsigned()->index();
            $table->foreign('type_user_id')->references('id')->on('type_users')->onDelete('no action');
            $table->string('token')->unique();
            $table->rememberToken();
            $table->engine = 'InnoDB';
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('users');
    }
}
