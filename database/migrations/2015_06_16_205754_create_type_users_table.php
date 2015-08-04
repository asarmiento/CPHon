<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTypeUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up() {
        Schema::create('type_users', function(Blueprint $table) {
        $table->increments('id');
        $table->string('name',80);
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
        Schema::drop('type_users');
    }
}
