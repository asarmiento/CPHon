<?php
/**
 * Created by PhpStorm.
 * User: Anwar Sarmiento
 * Date: 22/06/2015
 * Time: 10:35 AM
 */
Route::get('tipos/ver', ['as' => 'ver-tipos', 'uses' => 'TypeFormController@index']);
Route::get('tipos/crear', ['as' => 'crear-tipos', 'uses' => 'TypeFormController@create']);
Route::post('tipos/save', 'TypeFormController@store');
Route::get('tipos/editar/{id}', ['as' => 'editar-tipos', 'uses' => 'TypeFormController@edit']);
Route::delete('tipos/delete/{id}', ['as' => 'delete-tipo', 'uses' => 'TypeFormController@destroy']);
Route::patch('tipos/active/{id}', ['as' => 'active-tipo', 'uses' => 'TypeFormController@active']);
Route::put('tipos/update/{id}', 'TypeFormController@update');