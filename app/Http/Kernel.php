<?php

namespace AccountHon\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \AccountHon\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \AccountHon\Http\Middleware\VerifyCsrfToken::class,
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \AccountHon\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'guest' => \AccountHon\Http\Middleware\RedirectIfAuthenticated::class,
        'super_admin'=> \AccountHon\Http\Middleware\SuperAdministrador::class,
        'counter' => \AccountHon\Http\Middleware\Counter::class,
        'sessionOff' => \AccountHon\Http\Middleware\VerifictSession::class,
        'userSchool' => \AccountHon\Http\Middleware\VerifictSchool::class,
    ];
}
