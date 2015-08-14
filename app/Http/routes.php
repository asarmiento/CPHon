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


/**
 * After Authentication
 */
Route::resource('porcentajes', 'RecordPercentageController');

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