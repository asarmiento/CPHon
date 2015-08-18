<?php

use Illuminate\Database\Seeder;

class AffiliateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       factory(AccountHon\Entities\Affiliate::class,30)->create();
    }
}
