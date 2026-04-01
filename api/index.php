<?php

// Ensure required storage directories exist in /tmp on Vercel
$directories = [
    '/tmp/storage/bootstrap/cache',
    '/tmp/storage/framework/cache',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/framework/views',
    '/tmp/storage/logs',
];

foreach ($directories as $directory) {
    if (!is_dir($directory)) {
        mkdir($directory, 0755, true);
    }
}

/**
 * Forward Vercel requests to the Laravel index.php.
 *
 * Vercel's serverless functions look for an entry point in the api/ directory.
 */
require __DIR__ . '/../public/index.php';
