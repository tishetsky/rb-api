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
    $router->dispatch(\App\Request::createFromGlobals());
} catch (\Exception $e) {
    $router->response()->code(400)->json([
        'result' => false,
        'error' => $e->getCode(),
        'message' => $e->getMessage(),
    ]);
}
