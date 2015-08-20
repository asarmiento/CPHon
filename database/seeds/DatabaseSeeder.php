<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Model::unguard();

        $this->call('TypeUsersTableSeeder');
        $this->call('SchoolsTableSeeder');
        $this->call('UsersTableSeeder');
        $this->call('TasksTableSeeder');
        $this->call('MenuTableSeeder');
        $this->call('MenuTaskTableSeeder');
        $this->call('SchoolUserTableSeeder');
        $this->call('TaskUserTableSeeder');
        $this->call('AffiliateTableSeeder');
        $this->call('DuesTableSeeder');

        Model::reguard();
    }

}
