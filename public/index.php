<?php
// Habilitar reporte de errores (desactivar en producción)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Definir rutas base
define('BASEPATH', __DIR__ . '/../app/');
define('BASEURL', '/cmdb/public/');

// Iniciar sesión
session_start();

// Cargar dependencias
require BASEPATH . 'config/autoload.php';
require BASEPATH . 'config/config.php';

// Obtener URL
$url = isset($_GET['url']) ? explode('/', trim($_GET['url'], '/')) : [];

// Determinar controlador y método
$controllerName = !empty($url[0]) ? ucfirst($url[0]) . 'Controller' : 'DashboardController';
$method = !empty($url[1]) ? $url[1] : 'index';
$params = array_slice($url, 2);

// Lista de rutas públicas
$publicRoutes = [
    'auth/login',
    'auth/forgot-password',
    'auth/reset-password'
];

// Verificar autenticación
$currentRoute = (!empty($url[0]) ? $url[0] : 'dashboard') . '/' . $method;
if (!in_array($currentRoute, $publicRoutes) && !isset($_SESSION['user'])) {
    $_SESSION['redirect_url'] = implode('/', $url);
    header('Location: ' . BASEURL . 'auth/login');
    exit;
}

try {
    // Cargar controlador
    $controllerFile = BASEPATH . 'controllers/' . $controllerName . '.php';
    
    if (!file_exists($controllerFile)) {
        throw new Exception("Controlador no encontrado: $controllerName");
    }

    require $controllerFile;
    
    if (!class_exists($controllerName)) {
        throw new Exception("Clase $controllerName no existe");
    }

    $controller = new $controllerName();

    // Verificar método
    if (!method_exists($controller, $method)) {
        throw new Exception("Método $method no existe en $controllerName");
    }

    // Ejecutar controlador
    call_user_func_array([$controller, $method], $params);

} catch (Exception $e) {
    // Manejo de errores
    http_response_code(404);
    
    // Cargar vista de error si existe
    $errorView = BASEPATH . 'views/errors/404.php';
    if (file_exists($errorView)) {
        $message = ENVIRONMENT === 'development' ? $e->getMessage() : 'Página no encontrada';
        require $errorView;
    } else {
        die(ENVIRONMENT === 'development' ? $e->getMessage() : 'Error 404 - Página no encontrada');
    }
}