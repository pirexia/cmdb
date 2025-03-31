<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Core {
    protected $currentController = 'Dashboard';
    protected $currentMethod = 'index';
    protected $params = [];

    public function __construct() {
        $url = $this->getUrl();

        // Verificar si el controlador existe
        if (isset($url[0]) && file_exists('../app/controllers/' . ucwords($url[0]) . 'Controller.php')) {
            $this->currentController = ucwords($url[0]);
            unset($url[0]);
        }

        // Requerir el controlador
        require_once '../app/controllers/' . $this->currentController . 'Controller.php';
        $this->currentController = new $this->currentController;

        // Verificar si el método existe
        if (isset($url[1])) {
            if (method_exists($this->currentController, $url[1])) {
                $this->currentMethod = $url[1];
                unset($url[1]);
            }
        }

        // Obtener parámetros
        $this->params = $url ? array_values($url) : [];

        // Llamar al método con parámetros
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }

    public function getUrl() {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            return explode('/', $url);
        }
        return [];
    }
}