<?php

Route::get('configuracion/ver', ['as' => 'ver-configuracion', 'uses' => 'SettingsController@index']);
Route::get('configuracion/crear', ['as' => 'crear-configuracion', 'uses' => 'SettingsController@create']);
Route::post('configuracion/save', 'SettingsController@store');
Route::get('configuracion/editar/{id}', ['as' => 'editar-configuracion', 'uses' => 'SettingsController@edit']);
Route::delete('configuracion/delete/{token}', ['as' => 'delete-configuracion', 'uses' => 'SettingsController@destroy']);
Route::patch('configuracion/active/{token}', ['as' => 'active-configuracion', 'uses' => 'SettingsController@active']);
Route::post('configuracion/update', 'SettingsController@update');
Route::post('configuracion/status', 'SettingsController@status');
Route::delete('configuracion/deleteDetail/{id}', 'SettingsController@deleteDetail');