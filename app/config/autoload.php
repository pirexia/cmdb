<?php
defined('BASEPATH') OR exit('No direct script access allowed');

spl_autoload_register(function ($className) {
    $paths = [
        __DIR__ . '/../lib/',
        __DIR__ . '/../models/',
        __DIR__ . '/../controllers/'
    ];
    
    foreach ($paths as $path) {
        $file = $path . $className . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
    
    // Si no se encuentra, lanza excepción
    throw new Exception("Clase no encontrada: $className");
});