<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Illuminate\Database\Seeder;
/**
 * Description of MenuTableSeeder
 *
 * @author Anwar Sarmiento
 */
class MenuTableSeeder extends Seeder {
    //put your code here
    
    public function run() {
         \DB::table('menus')->insert([
            'id' => 1,
            'name' => 'MENU',
            'url' => '/MENU',
            'icon_font' => 'fa fa-bars',
            'priority' => 5,
            'resource' => false,
         ]);
         \DB::table('menus')->insert([
            'id' => 2,
            'name' => 'USUARIOS',
            'url' => '/USUARIOS',
            'icon_font' => 'fa fa-users',
            'priority' => 5,
            'resource' => false,
         ]);
           \DB::table('menus')->insert([
            'id' => 3,
            'name' => 'ROLES',
            'url' => '/ROLES',
            'icon_font' => 'fa fa-list-alt',
            'priority' => 5,
            'resource' => false,
         ]);
           \DB::table('menus')->insert([
            'id' => 4,
            'name' => 'TIPOS DE USUARIOS',
            'url' => '/TIPOS-DE-USUARIOS',
            'icon_font' => 'glyphicon glyphicon-th-large',
            'priority' => 5,
            'resource' => false,
         ]);
        \DB::table('menus')->insert([
            'id' => 5,
            'name' => 'AFILIADOS',
            'url' => '/AFILIADOS',
            'icon_font' => null,
            'priority' => 1,
            'resource' => true,
         ]);
        \DB::table('menus')->insert([
            'id' => 6,
            'name' => 'PORCENTAJES',
            'url' => '/PORCENTAJES',
            'icon_font' => null,
            'priority' => 1,
            'resource' => true,
         ]);
        \DB::table('menus')->insert([
            'id' => 7,
            'name' => 'CUOTAS',
            'url' => '/CUOTAS',
            'icon_font' => null,
            'priority' => 1,
            'resource' => true,
         ]);
          
    }
}
