<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$routes = Route::getRoutes();

foreach ($routes as $route) {
    $action = $route->getAction();
    if (isset($action['controller'])) {
        $controller = explode('@', $action['controller'])[0];
        if (! class_exists($controller)) {
            echo "Missing Controller: $controller\n";
        }
    }
}

echo "Check complete.\n";
