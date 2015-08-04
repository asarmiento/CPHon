<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('schools', function(Blueprint $table) {
        $table->increments('id');
        $table->string('name',150);
           $table->string('route',60);
           $table->string('charter',60);
        $table->string('phoneOne',20);
        $table->string('phoneTwo',20);
        $table->string('fax',150);
        $table->string('address',150);
        $table->string('town',150);
        $table->string('token')->unique();
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
        Schema::drop('schools');
    }
}
