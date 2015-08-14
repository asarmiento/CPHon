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
class MenuTaskTableSeeder extends Seeder {

    //put your code here

    public function run() {
        //menu
        \DB::table('menu_task')->insert([
            'task_id' => 1,
            'menu_id' => 1,
            'status' => 1
        ]);
        \DB::table('menu_task')->insert([
            'task_id' => 2,
            'menu_id' => 1,
            'status' => 1
        ]);
        \DB::table('menu_task')->insert([
            'task_id' => 3,
            'menu_id' => 1,
            'status' => 1
        ]);
        \DB::table('menu_task')->insert([
            'task_id' => 4,
            'menu_id' => 1,
            'status' => 1
        ]);
        //user
        \DB::table('menu_task')->insert([
            'task_id' => 1,
            'menu_id' => 2,
            'status' => 1
        ]);
        \DB::table('menu_task')->insert([
            'task_id' => 2,
            'menu_id' => 2,
            'status' => 1
        ]);
        \DB::table('menu_task')->insert([
            'task_id' => 3,
            'menu_id' => 2,
            'status' => 1
        ]);
        \DB::table('menu_task')->insert([
            'task_id' => 4,
            'menu_id' => 2,
            'status' => 1
        ]);
        //roles
        \DB::table('menu_task')->insert([
            'task_id' => 1,
            'menu_id' => 3,
            'status' => 1
        ]);
        \DB::table('menu_task')->insert([
            'task_id' => 4,
            'menu_id' => 3,
            'status' => 1
        ]);
        //tipos de usuarios
        \DB::table('menu_task')->insert([
            'task_id' => 1,
            'menu_id' => 4,
            'status' => 1
        ]);
        \DB::table('menu_task')->insert([
            'task_id' => 2,
            'menu_id' => 4,
            'status' => 1
        ]);
        \DB::table('menu_task')->insert([
            'task_id' => 3,
            'menu_id' => 4,
            'status' => 1
        ]);
        \DB::table('menu_task')->insert([
            'task_id' => 4,
            'menu_id' => 4,
            'status' => 1
        ]);
        //afiliados
        \DB::table('menu_task')->insert([
            'task_id' => 1,
            'menu_id' => 5,
            'status' => 1
        ]);
        \DB::table('menu_task')->insert([
            'task_id' => 2,
            'menu_id' => 5,
            'status' => 1
        ]);
        \DB::table('menu_task')->insert([
            'task_id' => 3,
            'menu_id' => 5,
            'status' => 1
        ]);
        \DB::table('menu_task')->insert([
            'task_id' => 4,
            'menu_id' => 5,
            'status' => 1
        ]);
        //porcentajes
        \DB::table('menu_task')->insert([
            'task_id' => 1,
            'menu_id' => 6,
            'status' => 1
        ]);
        \DB::table('menu_task')->insert([
            'task_id' => 2,
            'menu_id' => 6,
            'status' => 1
        ]);
        \DB::table('menu_task')->insert([
            'task_id' => 3,
            'menu_id' => 6,
            'status' => 1
        ]);
        \DB::table('menu_task')->insert([
            'task_id' => 4,
            'menu_id' => 6,
            'status' => 1
        ]);
        
    }

}
