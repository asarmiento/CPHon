<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTypeSeatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
	{
	 Schema::create('type_seats', function(Blueprint $table) {
            $table->increments('id');
            $table->string('abbreviation',5);
            $table->string('name',80);
            $table->integer('quatity')->unsigned();
            $table->string('year',4);
            $table->string('token',4);
         $table->integer('school_id')->unsigned()->index();
         $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
         $table->integer('user_created')->unsigned()->nullable()->index();
            $table->foreign('user_created')->references('id')->on('users')->onDelete('cascade');
            $table->integer('user_updated')->unsigned()->nullable()->index();
            $table->foreign('user_updated')->references('id')->on('users')->onDelete('cascade');
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
	public function down()
	{
		Schema::drop('type_seats');
	}
}
