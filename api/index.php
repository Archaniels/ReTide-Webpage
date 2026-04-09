<?php

// Force storage to /tmp — /var/task is read-only on Vercel
$_SERVER['LARAVEL_STORAGE_PATH'] = '/tmp/storage';

$directories = [
    '/tmp/storage/bootstrap/cache',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/framework/views',
    '/tmp/storage/logs',
    '/tmp/views',
    '/tmp/cache',
    '/tmp/sessions',
    '/tmp/logs',
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
