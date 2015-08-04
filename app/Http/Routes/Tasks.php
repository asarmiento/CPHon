<?php
/**
 * Created by PhpStorm.
 * User: Anwar Sarmiento
 * Date: 22/06/2015
 * Time: 10:35 AM
 */

Route::get('tareas/ver', ['as' => 'ver-tareas', 'uses' => 'TasksController@index']);
Route::get('tareas/crear', ['as' => 'crear-tareas', 'uses' => 'TasksController@create']);
Route::post('tareas/save', 'TasksController@store');
Route::get('tareas/editar/{id}', ['as' => 'editar-tareas', 'uses' => 'TasksController@edit']);
Route::delete('tareas/delete/{id}', ['as' => 'delete-tareas', 'uses' => 'TasksController@destroy']);
Route::patch('tareas/active/{id}', ['as' => 'active-tareas', 'uses' => 'TasksController@active']);
Route::put('tareas/update/{id}', 'TasksController@update');