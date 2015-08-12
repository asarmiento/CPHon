<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecordPorcentageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recordPorcentages', function(Blueprint $table) {
         $table->increments('id');
            $table->integer('month',2);
            $table->string('year',4);
            $table->string('fname',150);
            $table->string('sname',150);
            $table->string('flast',150);
            $table->string('slast',150);
            $table->string('address',150);
            $table->string('homePhone',150);
            $table->string('workPhone',150);
           
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
        //
    }
}
