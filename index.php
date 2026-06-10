<?php
session_start();
require_once 'config/db.php';
require_once 'controllers/BaseController.php';

// Simple Router
$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : 'auth/login';
$url = filter_var($url, FILTER_SANITIZE_URL);

// Route Aliases
$aliases = [
    'login' => 'auth/login',
    'register' => 'auth/register',
    'logout' => 'auth/logout'
];
if (array_key_exists($url, $aliases)) {
    $url = $aliases[$url];
}

$urlParts = explode('/', $url);

$controllerName = ucfirst($urlParts[0]) . 'Controller';
$methodName = isset($urlParts[1]) ? $urlParts[1] : 'index';

$controllerFile = 'controllers/' . $controllerName . '.php';

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    $controller = new $controllerName($pdo);
    
    if (method_exists($controller, $methodName)) {
        $params = array_slice($urlParts, 2);
        call_user_func_array([$controller, $methodName], $params);
    } else {
        echo "404 - Method not found";
    }
} else {
    echo "404 - Controller not found";
}
?>
