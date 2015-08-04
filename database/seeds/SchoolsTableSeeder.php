<?php

use Illuminate\Database\Seeder;

class SchoolsTableSeeder extends Seeder {

    public function run() {
        \DB::table('schools')->insert([
            'id' => 1,
            'name' => 'ESCUELA ADVENTISTA DE VALLE DE ANGELES',
            'charter' => '3-008-056720',
            'phoneOne' => '0000-0000',
            'phoneTwo' => '0000-0000',
            'fax' => '0000-0000',
            'address' => 'ENTRADA AL HOSPITAL ADVENTISTA',
            'town' => 'VALLE DE ANGELES',
            'token' => Crypt::encrypt('COLEGIO TECNICO PROFESIONAL DE QUEPOS')
        ]);
    }

}
