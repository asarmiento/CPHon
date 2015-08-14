<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAffiliatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('affiliates', function(Blueprint $table) {
         $table->increments('id');
            $table->string('code',150);
            $table->string('charter',150);
            $table->string('fname',150);
            $table->string('sname',150);
            $table->string('flast',150);
            $table->string('slast',150);
            $table->string('address',150);
            $table->string('homePhone',150);
            $table->string('workPhone',150);
            $table->string('job',150);
            $table->date('affiliation');
            $table->date('birthdate');
            $table->date('retirementDate');
            $table->decimal('salary',30,2);
            $table->string('observation',250);
            $table->enum('maritalStatus',['Casado','Soltero']);
            $table->enum('sex',['mujer','hombre']);
            $table->string('office',150);
            $table->enum('status',['activo','inactivo']);
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
         Schema::drop('affiliates');
    }
}
