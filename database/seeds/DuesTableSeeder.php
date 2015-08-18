<?php

use Illuminate\Database\Seeder;

class DuesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(AccountHon\Entities\Dues::class,30)->create();
    }
}
