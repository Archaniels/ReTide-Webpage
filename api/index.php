<?php

/**
 * Forward Vercel requests to the Laravel index.php.
 * 
 * Vercel's serverless functions look for an entry point in the api/ directory.
 */
require __DIR__ . '/../public/index.php';
