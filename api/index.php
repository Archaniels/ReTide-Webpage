<?php

/*
|--------------------------------------------------------------------------
| THIS IS THE Api/Index.php file
|--------------------------------------------------------------------------
*/

// Force storage to /tmp — /var/task is read-only on Vercel
$_SERVER['LARAVEL_STORAGE_PATH'] = '/tmp/storage';

// Override Bootstrap Cache paths to bypass hardcoded build paths
// and prevent read-only filesystem crashes.
$_SERVER['APP_SERVICES_CACHE'] = '/tmp/storage/bootstrap/cache/services.php';
$_SERVER['APP_PACKAGES_CACHE'] = '/tmp/storage/bootstrap/cache/packages.php';
$_SERVER['APP_CONFIG_CACHE'] = '/tmp/storage/bootstrap/cache/config.php';
$_SERVER['APP_ROUTES_CACHE'] = '/tmp/storage/bootstrap/cache/routes.php';
$_SERVER['APP_EVENTS_CACHE'] = '/tmp/storage/bootstrap/cache/events.php';

$directories = [
    '/tmp/storage/bootstrap/cache',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/framework/views',
    '/tmp/storage/logs',
];

foreach ($directories as $directory) {
    if (!is_dir($directory)) {
        mkdir($directory, 0755, true);
    }
}

if (function_exists('opcache_reset')) {
    opcache_reset();
}

require __DIR__ . '/../public/index.php';
