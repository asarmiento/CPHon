<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAffiliateRecordPorcentageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('affiliate_record_percentage', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('affiliate_id')->unsigned()->index();
            $table->foreign('affiliate_id')->references('id')->on('affiliates')->onDelete('no action');
            $table->integer('record_percentage_id')->unsigned()->index();
            $table->foreign('record_percentage_id')->references('id')->on('record_percentages')->onDelete('no action');
            $table->decimal('amount_affiliate',20,2);
            $table->decimal('amount',20,2);
            $table->string('consecutive',14);
            $table->string('token');
            $table->date('date_payment');
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
        Schema::drop('affiliate_record_percentage');
    }
}
