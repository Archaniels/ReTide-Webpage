<?php

// Force storage to /tmp before Laravel boots — /var/task is read-only on Vercel.
// Must be in $_SERVER so bootstrap/app.php picks it up.
$_SERVER['LARAVEL_STORAGE_PATH'] = '/tmp/storage';

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
