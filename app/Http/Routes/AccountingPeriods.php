<?php
/**
 * Created by PhpStorm.
 * User: Anwar Sarmiento
 * Date: 22/06/2015
 * Time: 11:05 AM
 */

Route::get('periodos-contables/ver', ['as' => 'ver-periodos-contables', 'uses' => 'AccountingPeriodsController@index']);
Route::get('periodos-contables/crear', ['as' => 'crear-periodos-contables', 'uses' => 'AccountingPeriodsController@create']);
Route::get('periodos-contables/editar/{token}', ['as' => 'editar-periodos-contables', 'uses' => 'AccountingPeriodsController@create']);
Route::post('periodos-contables/save', 'AccountingPeriodsController@store');
Route::delete('periodos-contables/delete/{token}', ['as' => 'delete-periodos-contables', 'uses' => 'AccountingPeriodsController@destroy']);
Route::patch('periodos-contables/active/{token}', ['as' => 'active-periodos-contables', 'uses' => 'AccountingPeriodsController@active']);