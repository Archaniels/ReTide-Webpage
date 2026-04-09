<?php

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
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

if (isset($_SERVER['LARAVEL_STORAGE_PATH'])) {
    $app->useStoragePath($_SERVER['LARAVEL_STORAGE_PATH']);
} elseif (isset($_SERVER['VERCEL'])) {
    $app->useStoragePath('/tmp/storage');
}

/*
|--------------------------------------------------------------------------
| Vercel /tmp Directory Overrides
|--------------------------------------------------------------------------
*/
if (env('VERCEL') || env('VERCEL_ENV')) {
    $app->useStoragePath('/tmp/laravel-storage');
    $app->useDatabasePath('/tmp/laravel-db');

    // CREATE THE DIRECTORIES (Required for View Service)
    $storagePath = '/tmp/laravel-storage';
    $viewCompiledPath = $storagePath . '/framework/views';
    if (!is_dir($viewCompiledPath)) {
        mkdir($viewCompiledPath, 0755, true);
    }

return $app;
