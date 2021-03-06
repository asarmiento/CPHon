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
        \DB::table('menu_task')->insert([
            'task_id' => 5,
            'menu_id' => 1,
            'status' => 0
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
        \DB::table('menu_task')->insert([
            'task_id' => 5,
            'menu_id' => 2,
            'status' => 0
        ]);
        //roles
        \DB::table('menu_task')->insert([
            'task_id' => 1,
            'menu_id' => 3,
            'status' => 1
        ]);
        \DB::table('menu_task')->insert([
            'task_id' => 2,
            'menu_id' => 3,
            'status' => 0
        ]);
        \DB::table('menu_task')->insert([
            'task_id' => 3,
            'menu_id' => 3,
            'status' => 0
        ]);
        \DB::table('menu_task')->insert([
            'task_id' => 4,
            'menu_id' => 3,
            'status' => 1
        ]);
        \DB::table('menu_task')->insert([
            'task_id' => 5,
            'menu_id' => 3,
            'status' => 0
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
        \DB::table('menu_task')->insert([
            'task_id' => 5,
            'menu_id' => 4,
            'status' => 0
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
        \DB::table('menu_task')->insert([
            'task_id' => 5,
            'menu_id' => 5,
            'status' => 0
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
        \DB::table('menu_task')->insert([
            'task_id' => 5,
            'menu_id' => 6,
            'status' => 0
        ]);
        //CUOTAS
        \DB::table('menu_task')->insert([
            'task_id' => 1,
            'menu_id' => 7,
            'status' => 1
        ]);
        \DB::table('menu_task')->insert([
            'task_id' => 2,
            'menu_id' => 7,
            'status' => 1
        ]);
        \DB::table('menu_task')->insert([
            'task_id' => 3,
            'menu_id' => 7,
            'status' => 1
        ]);
        \DB::table('menu_task')->insert([
            'task_id' => 4,
            'menu_id' => 7,
            'status' => 1
        ]);
        \DB::table('menu_task')->insert([
            'task_id' => 5,
            'menu_id' => 7,
            'status' => 0
        ]);
    }

}
