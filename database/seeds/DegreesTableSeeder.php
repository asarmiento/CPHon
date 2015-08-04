<?php 

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;

class DegreesTableSeeder extends Seeder {

    public function run() {
        
        \DB::table('degrees')->insert([
            'id' => 1,
            'code' => 'PG',
            'name' => 'PRIMER GRADO',
            'token' => Crypt::encrypt('PG'),
            'created_at' => '2015-07-01 00:12:50',
        ]);
        \DB::table('degrees')->insert([
            'id' => 2,
            'code' => 'SG',
            'name' => 'SEGUNDO GRADO',
            'token' => Crypt::encrypt('SG'),
            'created_at' => '2015-07-01 00:12:50',
        ]);
    }

}
