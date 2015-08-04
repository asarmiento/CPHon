<?php
/**
 * Created by PhpStorm.
 * User: Anwar Sarmiento
 * Date: 28/06/2015
 * Time: 04:38 PM
 */

Route::get('recibos/ver', ['as' => 'ver-recibos', 'uses' => 'ReceiptController@index']);
Route::get('recibos/crear', ['as' => 'crear-recibos', 'uses' => 'ReceiptController@create']);
Route::post('recibos/save', 'ReceiptController@store');
Route::get('recibos/ver/{token}', ['as' => 'recibos', 'uses' => 'ReceiptController@view']);
Route::get('recibos/editar/{token}', ['as' => 'editar-recibos', 'uses' => 'ReceiptController@edit']);
Route::delete('recibos/delete/{token}', ['as' => 'delete-recibos', 'uses' => 'ReceiptController@destroy']);
Route::patch('recibos/active/{token}', ['as' => 'active-recibos', 'uses' => 'ReceiptController@active']);
Route::put('recibos/update', 'AuxiliaryReceiptController@update');
Route::delete('recibos/deleteDetail/{id}', 'ReceiptController@deleteDetail');
Route::post('recibos/status', 'ReceiptController@status');
Route::get('recibos/impresion/{token}', ['as' => 'impresion-recibos', 'uses' => 'ReceiptController@report']);