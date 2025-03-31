<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Controller {
    protected $load;
    protected $db;
    protected $auth;
    protected $input;
    protected $session;
    protected $validator;
    
    private static $instance;

    public function __construct() {
        self::$instance = $this;
        
        // Inicializar componentes esenciales
        $this->load = new Loader();
        $this->db = new Database();
        $this->auth = new Auth();
        $this->input = new Input();
        $this->session = new Session();
        $this->validator = new Validator();
        
        // Cargar helper de autenticación
        $this->load->helper('auth');
    }

    /**
     * Obtener instancia del controlador (para helpers)
     */
    public static function &get_instance() {
        return self::$instance;
    }

    /**
     * Cargar modelo y asignarlo como propiedad
     */
    protected function model($model) {
        $modelName = $model;
        $this->$modelName = $this->load->model($model);
        return $this->$modelName;
    }

    /**
     * Redirección HTTP
     */
    protected function redirect($url) {
        header("Location: " . $url);
        exit();
    }

    /**
     * Cargar vista con layout
     */
    protected function view($view, $data = []) {
        extract($data);
        ob_start();
        require __DIR__ . '/../views/' . $view . '.php';
        $content = ob_get_clean();
        require __DIR__ . '/../views/layout.php';
    }

    /**
     * Respuesta JSON
     */
    protected function json($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }
}

// Función global para helpers (equivalente a get_instance() de CI)
function &get_instance() {
    return Controller::get_instance();
}