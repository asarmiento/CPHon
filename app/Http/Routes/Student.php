<?php


Route::get('estudiantes/ver', ['as' => 'ver-estudiantes', 'uses' => 'StudentController@index']);
Route::get('estudiantes/crear', ['as' => 'crear-estudiante', 'uses' => 'StudentController@create']);
Route::post('estudiantes/save', 'StudentController@store');
Route::get('estudiantes/editar/{token}', ['as' => 'editar-estudiante', 'uses' => 'StudentController@edit']);
Route::delete('estudiantes/delete/{token}', ['as' => 'delete-estudiantes', 'uses' => 'StudentController@destroy']);
Route::patch('estudiantes/active/{token}', ['as' => 'active-estudiantes', 'uses' => 'StudentController@active']);
Route::put('estudiantes/update', 'StudentController@update');
Route::get('estudiantes/matriculados', ['as' => 'estudiantes-matriculados', 'uses' => 'StudentController@enrolled']);
Route::post('estudiantes/enrolled', ['as' => 'crear-matricula', 'uses' => 'StudentController@saveEnrolled']);