<?php

$config = require_once '../config.php';

$router = new \Klein\Klein();

foreach ($config['routes'] as $method => $routes) {
    foreach ($routes as $url => $action) {
        if ([$class, $function] = explode('@', $action)) {
            $action = [new $class, $function];
        }

        $router->respond($method, $url, $action);
    }
}

try {
    $router->dispatch();
} catch (\Exception $e) {
    $router->response()->code(400)->json([
        'error' => $e->getCode(),
        'message' => $e->getMessage(),
    ]);
}

