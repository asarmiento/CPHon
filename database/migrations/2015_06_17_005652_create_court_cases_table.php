<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourtCasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
	{
	 Schema::create('court_cases', function(Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->integer('type_seat_id')->unsigned()->index();
            $table->foreign('type_seat_id')->references('id')->on('type_seats')->onDelete('no action');
            $table->string('token');
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
		Schema::drop('court_cases');
	}
}
