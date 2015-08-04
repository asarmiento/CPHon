<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepositsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('deposits', function(Blueprint $table) {
            $table->increments('id');
            $table->string('number', 150);
            $table->date('date');
            $table->string('account');
            $table->string('auxiliaryReceipt');
            $table->integer('amount')->unsigned();
            $table->integer('paymentsForm_id')->unsigned()->index();
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
    public function down() {
        Schema::drop('deposits');
    }

}
