<?php
/**
 * Created by PhpStorm.
 * User: Anwar Sarmiento
 * Date: 22/06/2015
 * Time: 11:00 AM
 */
Route::get('bancos/ver', ['as' => 'ver-bancos', 'uses' => 'BankController@index']);
Route::get('bancos/crear', ['as' => 'crear-bancos', 'uses' => 'BankController@create']);
Route::post('bancos/save', 'BankController@store');
Route::get('bancos/editar/{token}', ['as' => 'editar-bancos', 'uses' => 'BankController@edit']);
Route::delete('bancos/delete/{token}', ['as' => 'delete-banco', 'uses' => 'BankController@destroy']);
Route::patch('bancos/active/{token}', ['as' => 'active-banco', 'uses' => 'BankController@active']);
Route::put('bancos/update/{token}', 'BankController@update');