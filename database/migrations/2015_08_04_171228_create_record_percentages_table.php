<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecordPercentagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('record_percentages', function(Blueprint $table) {
            $table->increments('id');
            $table->string('year',4);
            $table->string('month',2);
            $table->decimal('percentage_affiliates',2,2);
            $table->decimal('percentage',2,2);
            $table->string('token',250);
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
        Schema::drop('record_percentages');
    }
}
