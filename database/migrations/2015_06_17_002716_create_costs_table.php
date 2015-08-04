<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCostsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('costs', function(Blueprint $table) {
            $table->increments('id');
            $table->string('year',4);
            $table->decimal('monthly_payment',30,2);
            $table->decimal('tuition',30,2);
            $table->integer('shares')->unsigned();
            $table->integer('degree_school_id')->unsigned()->index();
            $table->foreign('degree_school_id')->references('id')->on('degree_school')->onDelete('no action');
            $table->string('token');
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
        Schema::drop('costs');
    }

}
