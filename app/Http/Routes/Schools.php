<?php
/**
 * Created by PhpStorm.
 * User: Anwar Sarmiento
 * Date: 22/06/2015
 * Time: 10:33 AM
 */

Route::get('ver-institucion', ['as' => 'ver-institucion', 'uses' => 'SchoolsController@index']);
Route::get('crear-institucion', ['as' => 'crear-institucion', 'uses' => 'SchoolsController@create']);
Route::post('save-institucion', 'SchoolsController@store');
Route::get('route-institucion', 'SchoolsController@routeUser');
Route::get('editar-institucion/{id}', ['as' => 'editar-institucion', 'uses' => 'SchoolsController@edit']);
Route::delete('delete-institucion/{id}', ['as' => 'delete-institucion', 'uses' => 'SchoolsController@destroy']);
Route::patch('active-institucion/{id}', ['as' => 'active-institucion', 'uses' => 'SchoolsController@active']);
Route::put('update-institucion/{id}', 'SchoolsController@update');
