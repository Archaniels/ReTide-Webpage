<?php

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

// Prevent stale opcode cache from serving wrong paths across invocations
if (function_exists('opcache_reset')) {
    opcache_reset();
}

require __DIR__ . '/../public/index.php';
