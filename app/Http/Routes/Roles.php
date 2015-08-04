<?php

Route::get('roles/ver',['as'=>'ver-roles','uses'=>'UsersController@indexRole']);
Route::get('roles/crear',['as'=>'crear-roles','uses'=>'UsersController@indexRole']);
Route::get('roles/editar/{id}',['as'=>'editar-roles','uses'=>'UsersController@editRole']);
Route::put('roles/update','UsersController@updateRole');