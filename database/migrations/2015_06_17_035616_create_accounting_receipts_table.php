<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountingReceiptsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('accounting_receipts', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('receipt_number')->unsigned();
            $table->string('received_from', 53);
            $table->string('detail', 150);
            $table->decimal('amount', 30,2);
            $table->integer('line')->unsigned();
            $table->date('date');
            $table->integer('catalog_id')->unsigned()->index();
            $table->foreign('catalog_id')->references('id')->on('catalogs')->onDelete('no action');
            $table->integer('accounting_period_id')->unsigned()->index();
            $table->foreign('accounting_period_id')->references('id')->on('accounting_periods')->onDelete('no action');
            $table->integer('court_case_id')->unsigned()->index();
            $table->foreign('court_case_id')->references('id')->on('court_cases')->onDelete('no action');
            $table->integer('type_seat_id')->unsigned()->index();
            $table->foreign('type_seat_id')->references('id')->on('type_seats')->onDelete('no action');
            $table->integer('note_id')->unsigned()->nullable()->index();
            $table->foreign('note_id')->references('id')->on('notes')->onDelete('no action');
            $table->integer('deposit_id')->unsigned()->index();
            $table->foreign('deposit_id')->references('id')->on('deposits')->onDelete('no action');
            $table->integer('payment_from_id')->unsigned()->index();
            $table->foreign('payment_from_id')->references('id')->on('payment_froms')->onDelete('no action');
            $table->integer('user_created')->unsigned()->nullable()->index();
            $table->foreign('user_created')->references('id')->on('users')->onDelete('cascade');
            $table->integer('user_updated')->unsigned()->nullable()->index();
            $table->foreign('user_updated')->references('id')->on('users')->onDelete('cascade');
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
        Schema::drop('accounting_receipts');
    }

}
