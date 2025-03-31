<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Loader {
    public function helper($name) {
        $file = __DIR__ . '/../helpers/' . $name . '_helper.php';
        
        if (!file_exists($file)) {
            throw new Exception("Helper no encontrado: " . $name);
        }
        
        require_once $file;
        
        if (function_exists($name . '_helper_init')) {
            call_user_func($name . '_helper_init');
        }
    }

    public function model($model) {
        $modelFile = __DIR__ . '/../models/' . $model . '.php';
        
        if (!file_exists($modelFile)) {
            throw new Exception("Modelo no encontrado: " . $model);
        }
        
        require_once $modelFile;
        
        if (!class_exists($model)) {
            throw new Exception("Clase de modelo no existe: " . $model);
        }
        
        return new $model();
    }

    public function view($view, $data = []) {
        try {
            $viewFile = __DIR__ . '/../views/' . $view . '.php';
            
            if (!file_exists($viewFile)) {
                throw new Exception("Vista no encontrada: " . $view);
            }

            extract($data);
            ob_start();
            include $viewFile;
            $content = ob_get_clean();
            
            // Forzar limpieza de buffers y salida inmediata
            echo $content;
            if (ob_get_level() > 0) {
                ob_flush();
            }
            flush();
            
        } catch(Exception $e) {
            die("Error cargando vista: " . $e->getMessage());
        }
    }

    public function library($library) {
        $libraryFile = __DIR__ . '/../libraries/' . $library . '.php';
        
        if (!file_exists($libraryFile)) {
            throw new Exception("Librería no encontrada: " . $library);
        }
        
        require_once $libraryFile;
        
        if (!class_exists($library)) {
            throw new Exception("Clase de librería no existe: " . $library);
        }
        
        return new $library();
    }
}