<?php
/**
 * Created by PhpStorm.
 * User: Anwar Sarmiento
 * Date: 22/06/2015
 * Time: 11:04 AM
 */

Route::get('notas/ver', ['as' => 'ver-notas', 'uses' => 'NoteController@index']);
Route::get('notas/editar/{token}', ['as' => 'editar-notas', 'uses' => 'NoteController@edit']);
Route::put('notas/update', 'NoteController@update');