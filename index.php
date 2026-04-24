<?php
// Configuración de seguridad de sesiones (antes de session_start)
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_samesite', 'Lax');
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
    ini_set('session.cookie_secure', 1);
}

session_start();

/**
 * Helper global para escapar HTML (Prevención XSS)
 */
function e($string) {
    return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
}

// Generar token CSRF si no existe
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Load configuration
require_once 'config.php';

// Autoloader for classes
spl_autoload_register(function ($class_name) {
    $class_file = str_replace('\\', DIRECTORY_SEPARATOR, $class_name) . '.php';
    if (file_exists('core/' . $class_file)) {
        require_once 'core/' . $class_file;
    } elseif (file_exists('controllers/' . $class_file)) {
        require_once 'controllers/' . $class_file;
    } elseif (file_exists('models/' . $class_file)) {
        require_once 'models/' . $class_file;
    }
});

// Basic routing
$request_uri = urldecode($_SERVER['REQUEST_URI']); // URL-decode the request URI
$base_path = '/Inkatours';
$route = str_replace($base_path, '', $request_uri);
$route = trim(parse_url($route, PHP_URL_PATH), '/');
$route_parts = explode('/', $route);

$controller_name = !empty($route_parts[0]) ? ucfirst($route_parts[0]) . 'Controller' : 'HomeController';
$method_name = isset($route_parts[1]) && !empty($route_parts[1]) ? $route_parts[1] : 'index';
$params = array_slice($route_parts, 2);

// Default to HomeController if the requested controller doesn't exist
if (!class_exists($controller_name)) {
    $controller_name = 'HomeController';
}

$controller = new $controller_name;

if (!method_exists($controller, $method_name)) {
    $params = [$method_name];
    $method_name = 'index';
}

if (!method_exists($controller, $method_name)) {
    // Fallback to HomeController if 'index' method doesn't exist in the requested controller
    $controller_name = 'HomeController';
    $controller = new $controller_name;
    $method_name = 'index';
    $params = [];
}

call_user_func_array([$controller, $method_name], $params);

?>