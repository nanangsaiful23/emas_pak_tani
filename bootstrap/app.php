<?php

use App\Http\Middleware\Authenticate;
use App\Http\Middleware\RedirectIfAdmin;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\RedirectIfCashier;
use App\Http\Middleware\RedirectIfNotAdmin;
use App\Http\Middleware\RedirectIfNotCashier;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
        then: function () {
            // Sejak Laravel 8 namespace controller tidak otomatis; route proyek ini
            // memakai sintaks 'Controller@method', jadi namespace diberikan di sini.
            $namespace = 'App\Http\Controllers';

            Route::middleware('web')
                ->namespace($namespace)
                ->group(base_path('routes/web.php'));

            Route::prefix('api')
                ->middleware('api')
                ->namespace($namespace)
                ->group(base_path('routes/api.php'));

            Route::middleware(['web', 'cashier', 'auth:cashier'])
                ->prefix('cashier')
                ->as('cashier.')
                ->namespace($namespace.'\Cashier')
                ->group(base_path('routes/cashier.php'));

            Route::middleware(['web', 'admin', 'auth:admin'])
                ->prefix('admin')
                ->as('admin.')
                ->namespace($namespace.'\Admin')
                ->group(base_path('routes/admin.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'cashier' => RedirectIfNotCashier::class,
            'cashier.guest' => RedirectIfCashier::class,
            'admin' => RedirectIfNotAdmin::class,
            'admin.guest' => RedirectIfAdmin::class,
            'auth' => Authenticate::class,
            'guest' => RedirectIfAuthenticated::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
