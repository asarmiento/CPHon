<?php
/**
 * Created by PhpStorm.
 * User: Anwar Sarmiento
 * Date: 22/06/2015
 * Time: 10:46 AM
 */
Route::get('tipos-de-usuarios/ver', ['as' => 'ver-tipos-de-usuarios', 'uses' => 'TypeUsersController@index']);
Route::get('tipos-de-usuarios/crear', ['as' => 'crear-tipos-de-usuarios', 'uses' => 'TypeUsersController@create']);
Route::post('tipos-de-usuarios/save', 'TypeUsersController@store');
Route::get('tipos-de-usuarios/editar/{id}', ['as' => 'editar-tipos-de-usuarios', 'uses' => 'TypeUsersController@edit']);
Route::delete('tipos-de-usuarios/delete/{id}', ['as' => 'delete-tipo-de-usuario', 'uses' => 'TypeUsersController@destroy']);
Route::patch('tipos-de-usuarios/active/{id}', ['as' => 'active-tipo-de-usuario', 'uses' => 'TypeUsersController@active']);
Route::put('tipos-de-usuarios/update/{id}', 'TypeUsersController@update');