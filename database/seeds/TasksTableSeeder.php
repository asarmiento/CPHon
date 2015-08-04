<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Illuminate\Database\Seeder;
/**
 * Description of TasksTableSeeder
 *
 * @author Anwar Sarmiento
 */
class TasksTableSeeder extends Seeder {
    
   public function run() {
        \DB::table('tasks')->insert([
            'id' => 1,
            'name' => 'Ver'
         ]);
        \DB::table('tasks')->insert([
            'id' => 2,
            'name' => 'Crear'
         ]);
        \DB::table('tasks')->insert([
            'id' => 3,
            'name' => 'Editar'
         ]);
        \DB::table('tasks')->insert([
            'id' => 4,
            'name' => 'Eliminar'
         ]);
        \DB::table('tasks')->insert([
            'id' => 5,
            'name' => 'Reportes'
         ]);

    }
}
