<?php
require_once 'config.php';

session_start();

$config = Config::getInstance();
$db = $config->getDatabaseConnection();

// Load Routes
$webRoutes = require_once 'routes/web.php';
$apiRoutes = require_once 'routes/api.php';
$routes = array_merge($webRoutes, $apiRoutes);
// Get the requested URI
$requestUri = $_SERVER['REQUEST_URI'];
$requestUri = strtok($requestUri, '?');

// Match the request URI to a route
if (array_key_exists($requestUri, $routes)) {
    list($controllerName, $method) = $routes[$requestUri];
    $controllerClass = "src\\Controllers\\$controllerName";

    if (class_exists($controllerClass)) {
        $controller = new $controllerClass($db);

        if (method_exists($controller, $method)) {
            $controller->$method();
        } else {
            http_response_code(404);
            echo "Method not found: $method";
        }
    } else {
        http_response_code(404);
        echo "Controller not found: $controllerClass";
    }
} else {
    http_response_code(404);
    echo "Route not found";
}