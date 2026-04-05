<?php

/**
 * Vercel Serverless Function Entry Point for Laravel
 */

// Define required directories in /tmp for write access
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

// Map the request to public/index.php
require __DIR__ . '/../public/index.php';
