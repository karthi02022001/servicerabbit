<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('web')
                ->prefix('admin')
                ->group(base_path('routes/admin.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Register middleware aliases
        $middleware->alias([
            'admin.auth' => \App\Http\Middleware\AdminAuthenticate::class,
            'admin.permission' => \App\Http\Middleware\AdminPermission::class,
            'is_tasker' => \App\Http\Middleware\EnsureIsTasker::class,
            'tasker_verified' => \App\Http\Middleware\EnsureTaskerVerified::class,
        ]);

        // Redirect guests to login page
        $middleware->redirectGuestsTo(fn() => route('login'));

        // Redirect authenticated users
        $middleware->redirectUsersTo(fn() => route('user.dashboard'));
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
