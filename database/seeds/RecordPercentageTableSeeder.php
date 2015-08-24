<?php

use Illuminate\Database\Seeder;

class RecordPercentageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         \DB::table('record_percentages')->insert([
            'id' => 1,
            'year' => '1986',
            'month' => '01',
            'percentage_affiliates' => 3,
            'percentage' => 10,
            'token' => Hash::make('prueba'),
         ]);
    }
}
