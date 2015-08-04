<?php
/**
 * Created by PhpStorm.
 * User: Anwar Sarmiento
 * Date: 28/06/2015
 * Time: 04:38 PM
 */

Route::get('recibos-auxiliares/ver', ['as' => 'ver-recibos-auxiliares', 'uses' => 'AuxiliaryReceiptController@index']);
Route::get('recibos-auxiliares/crear', ['as' => 'crear-recibos-auxiliares', 'uses' => 'AuxiliaryReceiptController@create']);
Route::post('recibos-auxiliares/save', 'AuxiliaryReceiptController@store');
Route::get('recibos-auxiliares/ver/{token}', ['as' => 'recibos-auxiliares', 'uses' => 'AuxiliaryReceiptController@view']);
Route::get('recibos-auxiliares/editar/{token}', ['as' => 'editar-recibos-auxiliares', 'uses' => 'AuxiliaryReceiptController@edit']);
Route::delete('recibos-auxiliares/delete/{token}', ['as' => 'delete-recibos-auxiliares', 'uses' => 'AuxiliaryReceiptController@destroy']);
Route::patch('recibos-auxiliares/active/{token}', ['as' => 'active-recibos-auxiliares', 'uses' => 'AuxiliaryReceiptController@active']);
Route::put('recibos-auxiliares/update', 'AuxiliaryReceiptController@update');
Route::delete('recibos-auxiliares/deleteDetail/{id}', 'AuxiliaryReceiptController@deleteDetail');
Route::post('recibos-auxiliares/status', 'AuxiliaryReceiptController@status');
Route::get('recibos-auxiliares/impresion/{token}', ['as' => 'impresion-recibos-auxiliares', 'uses' => 'AuxiliaryReceiptController@report']);