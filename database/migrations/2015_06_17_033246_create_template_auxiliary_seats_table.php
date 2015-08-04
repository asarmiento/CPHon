<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTemplateAuxiliarySeatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('template_auxiliary_seats', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('financial_records_id')->unsigned()->index();
            $table->foreign('financial_records_id')->references('id')->on('financial_records')->onDelete('no action');
            $table->string('code', 35);
            $table->string('detail', 150);
            $table->decimal('amount', 30,2);
            $table->date('date');
            $table->integer('accounting_period_id')->unsigned()->index();
            $table->foreign('accounting_period_id')->references('id')->on('accounting_periods')->onDelete('no action');
            $table->integer('type_id')->unsigned()->index();
            $table->foreign('type_id')->references('id')->on('types')->onDelete('no action');
            $table->integer('type_seat_id')->unsigned()->index();
            $table->foreign('type_seat_id')->references('id')->on('type_seats')->onDelete('no action');
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
    public function down() {
        Schema::drop('template_auxiliary_seats');
    }
}
