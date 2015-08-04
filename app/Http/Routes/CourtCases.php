<?php

Route::get('cortes-de-caja/ver', ['as' => 'ver-cortes-de-caja', 'uses' => 'CourtCaseController@index']);
Route::get('cortes-de-caja/crear', ['as' => 'crear-cortes-de-caja', 'uses' => 'CourtCaseController@create']);
Route::post('cortes-de-caja/save', 'CourtCaseController@store');
Route::get('cortes-de-caja/impresion/{token}/{tipo}', ['as' => 'impresion-cortes-de-caja', 'uses' => 'CourtCaseController@report']);
Route::get('cortes-de-caja/editar/{token}', ['as' => 'editar-cortes-de-caja', 'uses' => 'CourtCaseController@edit']);
//Route::delete('cortes-de-caja/delete/{token}', ['as' => 'delete-cortes-de-caja', 'uses' => 'CourtCaseController@destroy']);
//Route::patch('cortes-de-caja/active/{token}', ['as' => 'active-cortes-de-caja', 'uses' => 'CourtCaseController@active']);
//Route::put('cortes-de-caja/update', 'CourtCaseController@update');