<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */

Route::get('/', function () {
    return redirect()->route('auth/login');
});

/* Log */
Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

// Authentication routes.
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', ['as' => 'auth/login', 'uses' => 'Auth\AuthController@postLogin']);
Route::get('auth/logout', ['as' => 'auth/logout', 'uses' => 'Auth\AuthController@getLogout']);

// Password reset link request routes...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');

// Route Test
Route::get('test', 'TestController@index');
Route::post('test', 'TestController@post');

/**
 * After Authentication
 */
Route::resource('porcentajes', 'RecordPercentageController');
Route::resource('afiliados', 'AffiliatesController');
Route::resource('cuotas', 'AffiliatesRecordPercentageController');
Route::get('searchAffiliate', 'AffiliatesController@search');
Route::get('reporte-sector-privado/{token}', ['as' => 'report-private' ,'uses'=>'AffiliatesController@reportPrivate']);
Route::get('reporte-afiliado/{token}', ['as' => 'report-affiliate' ,'uses'=>'AffiliatesController@reportAffiliate']);
Route::get('reporte-sueldo/{token}', ['as' => 'report-salary' ,'uses'=>'AffiliatesController@reportSalary']);
/*
 * Rutas de Tipos de Usuarios
 */
require __DIR__.'/Routes/TypeUsers.php';
/*
 * Rutas de Tareas
 */
require __DIR__.'/Routes/Tasks.php';
/*
 *  Rutas de Menu
 */
require __DIR__.'/Routes/Menu.php';
/*
 *  Rutas de usuarios
 */
require __DIR__.'/Routes/Users.php';
/*
 *  Rutas de Roles
 */
require __DIR__.'/Routes/Roles.php';