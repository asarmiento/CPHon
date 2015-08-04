<?php

Route::get('catalogos/ver', ['as' => 'ver-catalogos', 'uses' => 'CatalogsController@index']);
Route::post('catalogos/level', 'CatalogsController@level');
Route::get('catalogos/crear', ['as' => 'crear-catalogos', 'uses' => 'CatalogsController@create']);
Route::post('catalogos/save', 'CatalogsController@store');
Route::get('catalogos/editar/{token}', ['as' => 'editar-catalogos', 'uses' => 'CatalogsController@edit']);
Route::delete('catalogos/delete/{token}', ['as' => 'delete-catalogo', 'uses' => 'CatalogsController@destroy']);
Route::patch('catalogos/active/{token}', ['as' => 'active-catalogo', 'uses' => 'CatalogsController@active']);
Route::put('catalogos/update', 'CatalogsController@update');