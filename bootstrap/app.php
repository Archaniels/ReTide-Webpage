<?php

/*
|--------------------------------------------------------------------------
| THIS IS THE Bootstrap/App.php file
|--------------------------------------------------------------------------
*/

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'not_admin' => \App\Http\Middleware\RedirectIfAdmin::class,
        ]);

        $middleware->validateCsrfTokens(except: [
            '/payment/notification',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

// Tell Laravel to use the Vercel /tmp storage path defined in index.php
if (isset($_SERVER['LARAVEL_STORAGE_PATH'])) {
    $app->useStoragePath($_SERVER['LARAVEL_STORAGE_PATH']);
}

return $app;
