<?php
/**
 * Created by PhpStorm.
 * User: Anwar Sarmiento
 * Date: 22/06/2015
 * Time: 10:43 PM
 */
Route::get('tipos-de-asientos/ver', ['as' => 'ver-tipos-de-asientos', 'uses' => 'TypeSeatController@index']);
Route::get('tipos-de-asientos/crear', ['as' => 'crear-tipos-de-asientos', 'uses' => 'TypeSeatController@create']);
Route::post('tipos-de-asientos/save', 'TypeSeatController@store');
Route::get('tipos-de-asientos/editar/{token}', ['as' => 'editar-tipos-de-asientos', 'uses' => 'TypeSeatController@edit']);
Route::put('tipos-de-asientos/update', 'TypeSeatController@update');