<?php
/**
 * Created by PhpStorm.
 * User: Anwar Sarmiento
 * Date: 22/06/2015
 * Time: 11:00 AM
 */
Route::get('grados/ver', ['as' => 'ver-grados', 'uses' => 'DegreeController@index']);
Route::get('grados/crear', ['as' => 'crear-grados', 'uses' => 'DegreeController@create']);
Route::post('grados/save', 'DegreeController@store');
Route::get('grados/editar/{token}', ['as' => 'editar-grados', 'uses' => 'DegreeController@edit']);
Route::delete('grados/delete/{token}', ['as' => 'delete-grado', 'uses' => 'DegreeController@destroy']);
Route::patch('grados/active/{token}', ['as' => 'active-grado', 'uses' => 'DegreeController@active']);
Route::put('grados/update', 'DegreeController@update');