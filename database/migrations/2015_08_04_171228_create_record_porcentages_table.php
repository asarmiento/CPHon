<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecordPorcentagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('record_porcentages', function(Blueprint $table) {
            $table->increments('id');
            $table->string('year',4);
            $table->string('month',2);
            $table->string('porcent_affiliates',150);
            $table->string('porcent',150);
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
        Schema::drop('record_porcentages');
    }
}
