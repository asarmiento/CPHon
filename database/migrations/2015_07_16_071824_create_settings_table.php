<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function(Blueprint $table) {
            $table->integer('catalog_id')->unsigned()->index();
            $table->foreign('catalog_id')->references('id')->on('catalogs')->onDelete('cascade');
            $table->integer('type_seat_id')->unsigned()->index();
            $table->foreign('type_seat_id')->references('id')->on('type_seats')->onDelete('cascade');
             $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('settings');
    }
}
