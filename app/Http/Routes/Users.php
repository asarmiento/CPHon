<?php
/**
 * Created by PhpStorm.
 * User: Anwar Sarmiento
 * Date: 22/06/2015
 * Time: 10:36 AM
 */
Route::get('usuarios/ver', ['as' => 'ver-usuarios', 'uses' => 'UsersController@index']);
Route::get('usuarios/crear', ['as' => 'crear-usuarios', 'uses' => 'UsersController@create']);
Route::post('usuarios/save', 'UsersController@store');
Route::get('usuarios/editar/{id}', ['as' => 'editar-usuarios', 'uses' => 'UsersController@edit']);
Route::delete('usuarios/delete/{id}', ['as' => 'delete-usuario', 'uses' => 'UsersController@destroy']);
Route::patch('usuarios/active/{id}', ['as' => 'active-usuario', 'uses' => 'UsersController@active']);
Route::put('usuarios/update/{id}', 'UsersController@update');