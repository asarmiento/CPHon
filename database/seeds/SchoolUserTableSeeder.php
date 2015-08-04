<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Illuminate\Database\Seeder;
/**
 * Description of SchoolsHasUsersTableSeeder
 *
 * @author Anwar Sarmiento
 */
class SchoolUserTableSeeder extends Seeder{
    //put your code here
     public function run() {
        \DB::table('school_user')->insert([
            'user_id' => 1,
            'school_id' => 1
         ]);
        \DB::table('school_user')->insert([
             'user_id' => 2,
            'school_id' => 1
         ]);
    }
}
