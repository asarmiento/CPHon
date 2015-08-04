<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBalancePeriodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('balance_periods', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('school_id')->unsigned()->index();
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('no action');
            $table->integer('catalog_id')->unsigned()->index();
            $table->foreign('catalog_id')->references('id')->on('catalogs')->onDelete('no action');
            $table->decimal('amount',30,2);
            $table->string('period',6);
            $table->string('year',4);
            $table->engine = 'InnoDB';
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
        Schema::drop('balance_periods');
    }
}
