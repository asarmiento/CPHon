<?php
/**
 * Created by PhpStorm.
 * User: Anwar Sarmiento
 * Date: 03/07/2015
 * Time: 10:31 AM
 */

Route::get('reportes/estado-de-cuenta/excel/{token}', ['as' => 'ver-estado-de-cuenta', 'uses' => 'ReportExcel\EstadoDeCuenta@estadoCuenta']);
Route::get('reportes/estado-de-cuenta-auxiliar/excel/{token}', ['as' => 'ver-estado-de-cuenta-auxiliar', 'uses' => 'ReportExcel\EstadoCuentaAuxiliaryController@estadoCuentaAuxiliary']);
Route::get('reportes/asientos/excel/{token}', ['as' => 'ver-asientos-excel', 'uses' => 'ReportExcel\Seatings@index']);
Route::get('reportes/asientos-auxiliary/excel/{token}', ['as' => 'ver-asientos-auxiliary', 'uses' => 'ReportExcel\AuxiliarySeatings@index']);
Route::get('reportes/balance-de-comprobacion', ['as' => 'ver-balance-comprobacion', 'uses' => 'ReportExcel\checkingBalance@index']);
Route::get('reportes/balance-comprobacion/{dateRange}', ['as' => 'balance-comprobacion', 'uses' => 'ReportExcel\checkingBalance@report']);
Route::get('reportes/balance-de-estudiantes', ['as' => 'ver-balance-estudiantes', 'uses' => 'ReportExcel\StudentsBalance@index']);
Route::get('reportes/recibo/excel', ['as' => 'ver-recibo-excel', 'uses' => 'ReportExcel\AccountingReceipt@report']);

# estado resultado
Route::get('reportes/estado-de-resultado/excel', ['as' => 'ver-recibo-excel', 'uses' => 'ReportExcel\EstadoResultado@report']);