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
            'year' => 2015,
            'month' => '02',
            'percentage_affiliates' => 10,
            'percentage' => 8,
            'token' => 'sdasdasde5254567b35wqvaq5ac64a3b6a6a6',
         ]);
    }
}
