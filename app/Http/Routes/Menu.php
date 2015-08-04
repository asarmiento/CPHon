<?php
/**
 * Created by PhpStorm.
 * User: Anwar Sarmiento
 * Date: 22/06/2015
 * Time: 10:35 AM
 */
Route::get('menu/ver', ['as' => 'ver-menu', 'uses' => 'MenuController@index']);
Route::get('menu/crear', ['as' => 'crear-menu', 'uses' => 'MenuController@create']);
Route::post('menu/save', 'MenuController@store');
Route::get('menu/editar/{id}', ['as' => 'editar-menu', 'uses' => 'MenuController@edit']);
Route::delete('menu/delete/{id}', ['as' => 'delete-menu', 'uses' => 'MenuController@destroy']);
Route::patch('menu/active/{id}', ['as' => 'active-menu', 'uses' => 'MenuController@active']);
Route::put('menu/update/{id}', 'MenuController@update');