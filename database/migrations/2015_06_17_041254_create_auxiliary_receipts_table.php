<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuxiliaryReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('auxiliary_receipts', function(Blueprint $table) {
            $table->increments('id');
            $table->string('receipt_number',30);
            $table->string('received_from',100);
            $table->string('detail',150);
            $table->decimal('amount',30,2);
            $table->integer('line')->unsigned();
            $table->date('date');
            $table->enum('status',['aplicado','no aplicado']);
            $table->string('token');
            $table->integer('financial_record_id')->unsigned()->index();
            $table->foreign('financial_record_id')->references('id')->on('financial_records')->onDelete('no action');
            $table->integer('accounting_period_id')->unsigned()->index();
            $table->foreign('accounting_period_id')->references('id')->on('accounting_periods')->onDelete('no action');
            $table->integer('court_case_id')->unsigned()->nullable()->index();
            $table->foreign('court_case_id')->references('id')->on('court_cases')->onDelete('no action');
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
        Schema::drop('auxiliary_receipts');
    }
}
