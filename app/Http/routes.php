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
 * Rutas al dashboard usuarios.
 */

Route::group(['prefix' => 'institucion'], function () {

    Route::get('/', 'SchoolsController@listSchools');
    /* Test para hacer pruebas */

    Route::group(['prefix' =>  'inst', 'middleware'=> 'userSchool'], function () {
        Route::get('test', 'TestController@index');

        Route::get('/', ['as' => 'dashboard', function () {  return view('home'); }]);

        /*
        * Rutas de Bancos
        */
        require __DIR__.'/Routes/Bank.php';

        /*
         * Rutas de Grados
         */
        require __DIR__.'/Routes/Degrees.php';

        /*
         * Rutas de Notas
         */
        require __DIR__.'/Routes/Note.php';

        /*
         * Rutas de Periodos Contables
        */
        require __DIR__.'/Routes/AccountingPeriods.php';

        /*
         * Rutas de Tipos de Pago
         */
        require __DIR__.'/Routes/PaymentForm.php';
        
        /*
         * Rutas de Tipos de Asientos
         */
        require __DIR__.'/Routes/TypeSeat.php';
        
        /*
         * Rutas de Costos
         */
        require __DIR__.'/Routes/Costs.php';
        
        /*
         * Rutas de Estudiantes
         */
        require __DIR__.'/Routes/Student.php';
        
        /*
         * Rutas de Asientos Auxiliares
         */
        require __DIR__.'/Routes/AuxiliarySeat.php';

        /*
         * Rutas de Asientos Auxiliares
         */
        require __DIR__.'/Routes/AuxiliaryReceipt.php';

        /*
         * Rutas de Catalogos
         */
        require __DIR__.'/Routes/Catalogs.php';

         /*
         * Rutas de Asientos
         */
        require __DIR__.'/Routes/Seatings.php';

        /*
         * Rutas de Asientos Auxiliares
         */
        require __DIR__.'/Routes/Receipt.php';

        /*
         * Rutas de Asientos Auxiliares
         */
        require __DIR__.'/Routes/ReportExcel.php';

        /*
         * Rutas de Cortes de Caja
         */
        require __DIR__.'/Routes/CourtCases.php';

        /*
         * Rutas de Settings
         */
        require __DIR__.'/Routes/Settings.php';
    });

});

/**
 *  Routes for Type User: Super Admin
 */
/**
 * Institución
 */
require __DIR__.'/Routes/Schools.php';
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

/*
 * Rutas de Tipos
 */
require __DIR__.'/Routes/TypeForm.php';




Route::get('usuarios', function () {
    echo "colegio/piura/usuarios";
});

Route::post('route-institucion', 'SchoolsController@routeUser');