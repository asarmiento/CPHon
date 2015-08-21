<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Illuminate\Database\Seeder;
/**
 * Description of MenuTaskTableSeeder
 *
 * @author Anwar Sarmiento
 */
class TaskUserTableSeeder extends Seeder {
    //put your code here
    
    public function run() {
        /**
         * User 1: Francisco
         */
        //menu
        \DB::table('task_user')->insert([
            'task_id' => 1,
            'menu_id' => 1,
            'status' => 1, 
            'user_id' =>1 
        ]);
        \DB::table('task_user')->insert([
            'task_id' => 2,
            'menu_id' => 1,
            'status' => 1, 
            'user_id' =>1 
        ]);
        \DB::table('task_user')->insert([
            'task_id' => 3,
            'menu_id' => 1,
            'status' => 1, 
            'user_id' =>1 
        ]);
        \DB::table('task_user')->insert([
            'task_id' => 4,
            'menu_id' => 1,
            'status' => 1, 
            'user_id' =>1 
        ]);
        //usuarios
        \DB::table('task_user')->insert([
            'task_id' => 1,
            'menu_id' => 2,
            'status' => 1, 
            'user_id' =>1 
        ]);
        \DB::table('task_user')->insert([
            'task_id' => 2,
            'menu_id' => 2,
            'status' => 1, 
            'user_id' =>1 
        ]);
        \DB::table('task_user')->insert([
            'task_id' => 3,
            'menu_id' => 2,
            'status' => 1, 
            'user_id' =>1 
        ]);
        \DB::table('task_user')->insert([
            'task_id' => 4,
            'menu_id' => 2,
            'status' => 1, 
            'user_id' =>1 
        ]);
        //roles
        \DB::table('task_user')->insert([
            'task_id' => 1,
            'menu_id' => 3,
            'status' => 1, 
            'user_id' =>1 
        ]);
        \DB::table('task_user')->insert([
            'task_id' => 4,
            'menu_id' => 3,
            'status' => 1, 
            'user_id' =>1 
        ]);
        //tipos de usuarios
        \DB::table('task_user')->insert([
            'task_id' => 1,
            'menu_id' => 4,
            'status' => 1, 
            'user_id' =>1 
        ]);
        \DB::table('task_user')->insert([
            'task_id' => 2,
            'menu_id' => 4,
            'status' => 1, 
            'user_id' =>1 
        ]);
        \DB::table('task_user')->insert([
            'task_id' => 3,
            'menu_id' => 4,
            'status' => 1, 
            'user_id' =>1 
        ]);
        \DB::table('task_user')->insert([
            'task_id' => 4,
            'menu_id' => 4,
            'status' => 1, 
            'user_id' =>1 
        ]);
        //afiliados
        \DB::table('task_user')->insert([
            'task_id' => 1,
            'menu_id' => 5,
            'status' => 1, 
            'user_id' =>1 
        ]);
        \DB::table('task_user')->insert([
            'task_id' => 2,
            'menu_id' => 5,
            'status' => 1, 
            'user_id' =>1 
        ]);
        \DB::table('task_user')->insert([
            'task_id' => 3,
            'menu_id' => 5,
            'status' => 1, 
            'user_id' =>1 
        ]);
        \DB::table('task_user')->insert([
            'task_id' => 4,
            'menu_id' => 5,
            'status' => 1, 
            'user_id' =>1 
        ]);
        //porcentajes
        \DB::table('task_user')->insert([
            'task_id' => 1,
            'menu_id' => 6,
            'status' => 1, 
            'user_id' =>1 
        ]);
        \DB::table('task_user')->insert([
            'task_id' => 2,
            'menu_id' => 6,
            'status' => 1, 
            'user_id' =>1 
        ]);
        \DB::table('task_user')->insert([
            'task_id' => 3,
            'menu_id' => 6,
            'status' => 1, 
            'user_id' =>1 
        ]);
        \DB::table('task_user')->insert([
            'task_id' => 4,
            'menu_id' => 6,
            'status' => 1, 
            'user_id' =>1 
        ]);
        //cuotas
        \DB::table('task_user')->insert([
            'task_id' => 1,
            'menu_id' => 7,
            'status' => 1, 
            'user_id' => 1 
        ]);
        \DB::table('task_user')->insert([
            'task_id' => 2,
            'menu_id' => 7,
            'status' => 1, 
            'user_id' => 1 
        ]);
        \DB::table('task_user')->insert([
            'task_id' => 3,
            'menu_id' => 7,
            'status' => 1, 
            'user_id' => 1 
        ]);
        \DB::table('task_user')->insert([
            'task_id' => 4,
            'menu_id' => 7,
            'status' => 1, 
            'user_id' => 1 
        ]);

        /**
         * User 2: Anwar
         */
        //menu
        \DB::table('task_user')->insert([
            'task_id' => 1,
            'menu_id' => 1,
            'status' => 1, 
            'user_id' =>2 
        ]);
        \DB::table('task_user')->insert([
            'task_id' => 2,
            'menu_id' => 1,
            'status' => 1, 
            'user_id' =>2 
        ]);
        \DB::table('task_user')->insert([
            'task_id' => 3,
            'menu_id' => 1,
            'status' => 1, 
            'user_id' =>2 
        ]);
        \DB::table('task_user')->insert([
            'task_id' => 4,
            'menu_id' => 1,
            'status' => 1, 
            'user_id' =>2 
        ]);
        //usuarios
        \DB::table('task_user')->insert([
            'task_id' => 1,
            'menu_id' => 2,
            'status' => 1, 
            'user_id' =>2 
        ]);
        \DB::table('task_user')->insert([
            'task_id' => 2,
            'menu_id' => 2,
            'status' => 1, 
            'user_id' =>2 
        ]);
        \DB::table('task_user')->insert([
            'task_id' => 3,
            'menu_id' => 2,
            'status' => 1, 
            'user_id' =>2 
        ]);
        \DB::table('task_user')->insert([
            'task_id' => 4,
            'menu_id' => 2,
            'status' => 1, 
            'user_id' =>2 
        ]);
        //roles
        \DB::table('task_user')->insert([
            'task_id' => 1,
            'menu_id' => 3,
            'status' => 1, 
            'user_id' =>2 
        ]);
        \DB::table('task_user')->insert([
            'task_id' => 4,
            'menu_id' => 3,
            'status' => 1, 
            'user_id' =>2 
        ]);
        //tipos de usuarios
        \DB::table('task_user')->insert([
            'task_id' => 1,
            'menu_id' => 4,
            'status' => 1, 
            'user_id' =>2 
        ]);
        \DB::table('task_user')->insert([
            'task_id' => 2,
            'menu_id' => 4,
            'status' => 1, 
            'user_id' =>2 
        ]);
        \DB::table('task_user')->insert([
            'task_id' => 3,
            'menu_id' => 4,
            'status' => 1, 
            'user_id' =>2 
        ]);
        \DB::table('task_user')->insert([
            'task_id' => 4,
            'menu_id' => 4,
            'status' => 1, 
            'user_id' =>2 
        ]);
        //afiliados
        \DB::table('task_user')->insert([
            'task_id' => 1,
            'menu_id' => 5,
            'status' => 1, 
            'user_id' =>2 
        ]);
        \DB::table('task_user')->insert([
            'task_id' => 2,
            'menu_id' => 5,
            'status' => 1, 
            'user_id' =>2 
        ]);
        \DB::table('task_user')->insert([
            'task_id' => 3,
            'menu_id' => 5,
            'status' => 1, 
            'user_id' =>2 
        ]);
        \DB::table('task_user')->insert([
            'task_id' => 4,
            'menu_id' => 5,
            'status' => 1, 
            'user_id' =>2 
        ]);
        //porcentajes
        \DB::table('task_user')->insert([
            'task_id' => 1,
            'menu_id' => 6,
            'status' => 1, 
            'user_id' =>2 
        ]);
        \DB::table('task_user')->insert([
            'task_id' => 2,
            'menu_id' => 6,
            'status' => 1, 
            'user_id' =>2 
        ]);
        \DB::table('task_user')->insert([
            'task_id' => 3,
            'menu_id' => 6,
            'status' => 1, 
            'user_id' =>2 
        ]);
        \DB::table('task_user')->insert([
            'task_id' => 4,
            'menu_id' => 6,
            'status' => 1, 
            'user_id' =>2 
        ]);
        //cuotas
        \DB::table('task_user')->insert([
            'task_id' => 1,
            'menu_id' => 7,
            'status' => 1, 
            'user_id' => 2
        ]);
        \DB::table('task_user')->insert([
            'task_id' => 2,
            'menu_id' => 7,
            'status' => 1, 
            'user_id' => 2
        ]);
        \DB::table('task_user')->insert([
            'task_id' => 3,
            'menu_id' => 7,
            'status' => 1, 
            'user_id' => 2
        ]);
        \DB::table('task_user')->insert([
            'task_id' => 4,
            'menu_id' => 7,
            'status' => 1, 
            'user_id' => 2
        ]);
        /* User : Andrea Varela */
        //afiliados
        \DB::table('task_user')->insert([
            'task_id' => 1,
            'menu_id' => 5,
            'status' => 1, 
            'user_id' => 3
        ]);
        \DB::table('task_user')->insert([
            'task_id' => 2,
            'menu_id' => 5,
            'status' => 1, 
            'user_id' => 3
        ]);
        \DB::table('task_user')->insert([
            'task_id' => 3,
            'menu_id' => 5,
            'status' => 1, 
            'user_id' => 3
        ]);
        \DB::table('task_user')->insert([
            'task_id' => 4,
            'menu_id' => 5,
            'status' => 1, 
            'user_id' => 3
        ]);
        //porcentajes
        \DB::table('task_user')->insert([
            'task_id' => 1,
            'menu_id' => 6,
            'status' => 1, 
            'user_id' => 3
        ]);
        \DB::table('task_user')->insert([
            'task_id' => 2,
            'menu_id' => 6,
            'status' => 1, 
            'user_id' => 3
        ]);
        \DB::table('task_user')->insert([
            'task_id' => 3,
            'menu_id' => 6,
            'status' => 1, 
            'user_id' => 3
        ]);
        \DB::table('task_user')->insert([
            'task_id' => 4,
            'menu_id' => 6,
            'status' => 1, 
            'user_id' => 3
        ]);
        //cuotas
        \DB::table('task_user')->insert([
            'task_id' => 1,
            'menu_id' => 7,
            'status' => 1, 
            'user_id' => 3
        ]);
        \DB::table('task_user')->insert([
            'task_id' => 2,
            'menu_id' => 7,
            'status' => 1, 
            'user_id' => 3
        ]);
        \DB::table('task_user')->insert([
            'task_id' => 3,
            'menu_id' => 7,
            'status' => 1, 
            'user_id' => 3
        ]);
        \DB::table('task_user')->insert([
            'task_id' => 4,
            'menu_id' => 7,
            'status' => 1, 
            'user_id' => 3
        ]);
         
    }
}
