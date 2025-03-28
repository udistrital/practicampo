<?php

namespace PractiCampoUD\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \PractiCampoUD\Http\Middleware\TrustProxies::class,
        \PractiCampoUD\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \PractiCampoUD\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        // \PractiCampoUD\Http\Middleware\Admin::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \PractiCampoUD\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \PractiCampoUD\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            'throttle:60,1',
            'bindings',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \PractiCampoUD\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \PractiCampoUD\Http\Middleware\RedirectIfAuthenticated::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'admin' => \PractiCampoUD\Http\Middleware\Admin::class,
        'docente' => \PractiCampoUD\Http\Middleware\Docente::class,
        'coord' => \PractiCampoUD\Http\Middleware\Coord::class,
        'asistD' => \PractiCampoUD\Http\Middleware\AsistD::class,
        'decano' => \PractiCampoUD\Http\Middleware\Decano::class,
        'viceAcad' => \PractiCampoUD\Http\Middleware\ViceAcademica::class,
        'transport' => \PractiCampoUD\Http\Middleware\Transportador::class,
        'activo' => \PractiCampoUD\Http\Middleware\Activo::class,
        'inactivo' => \PractiCampoUD\Http\Middleware\Inactivo::class,
        'otros' => \PractiCampoUD\Http\Middleware\Otros::class,
        'estudiante' => \PractiCampoUD\Http\Middleware\Estudiante::class,
        // 'user' =>\PractiCampoUD\Http\Middleware\User::class,
    ];

    /**
     * The priority-sorted list of middleware.
     *
     * This forces non-global middleware to always be in the given order.
     *
     * @var array
     */
    protected $middlewarePriority = [
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \PractiCampoUD\Http\Middleware\Authenticate::class,
        \Illuminate\Session\Middleware\AuthenticateSession::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
        \Illuminate\Auth\Middleware\Authorize::class,
    ];
}
