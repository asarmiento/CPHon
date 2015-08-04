<?php

Route::get('asientos-auxiliares/ver', ['as' => 'ver-asientos-auxiliares', 'uses' => 'AuxiliarySeatController@index']);
Route::get('asientos-auxiliares/crear', ['as' => 'crear-asientos-auxiliares', 'uses' => 'AuxiliarySeatController@create']);
Route::post('asientos-auxiliares/save', 'AuxiliarySeatController@store');
Route::get('asientos-auxiliares/ver/{token}', ['as' => 'asientos-auxiliares', 'uses' => 'AuxiliarySeatController@view']);
Route::delete('asientos-auxiliares/delete/{token}', ['as' => 'delete-asientos-auxiliares', 'uses' => 'AuxiliarySeatController@destroy']);
Route::patch('asientos-auxiliares/active/{token}', ['as' => 'active-asientos-auxiliares', 'uses' => 'AuxiliarySeatController@active']);
Route::put('asientos-auxiliares/update', 'AuxiliarySeatController@update');
Route::post('asientos-auxiliares/status', 'AuxiliarySeatController@status');
Route::delete('asientos-auxiliares/deleteDetail/{id}', 'AuxiliarySeatController@deleteDetail');
Route::post('asientos-auxiliares/other', 'AuxiliarySeatController@other');