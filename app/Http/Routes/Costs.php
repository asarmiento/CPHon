<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
Route::get('costos/ver', ['as' => 'ver-costos', 'uses' => 'CostController@index']);
Route::get('costos/crear', ['as' => 'crear-costos', 'uses' => 'CostController@create']);
Route::post('costos/save', 'CostController@store');
Route::get('costos/editar/{token}', ['as' => 'editar-costos', 'uses' => 'CostController@edit']);
Route::delete('costos/delete/{token}', ['as' => 'delete-costos', 'uses' => 'CostController@destroy']);
Route::patch('costos/active/{token}', ['as' => 'active-costos', 'uses' => 'CostController@active']);
Route::put('costos/update', 'CostController@update');