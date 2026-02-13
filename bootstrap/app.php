<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        commands: __DIR__.'/../routes/console.php',
        api: __DIR__.'/../routes/api.php', // 👈 add your API route file
        web: __DIR__.'/../routes/web.php',
        health: '/up',

        // 👇 This callback runs after Laravel loads its core routes
        then: function () {
            // Load your custom admin routes with middleware
            Route::prefix('admin')
                ->middleware(['web', 'admin'])
                ->group(base_path('routes/admin.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // 👇 Register Sanctum for API routes
        $middleware->group('api', [
            EnsureFrontendRequestsAreStateful::class,
        ]);  
        // Register route middleware
    $middleware->alias([
        'admin' => \App\Http\Middleware\AdminAuth::class,
    ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
