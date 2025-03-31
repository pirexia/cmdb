<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Input {
    public function post($key = null, $default = null) {
        if ($key === null) {
            return $_POST;
        }
        return $_POST[$key] ?? $default;
    }

    public function get($key = null, $default = null) {
        if ($key === null) {
            return $_GET;
        }
        return $_GET[$key] ?? $default;
    }

    public function input($key, $default = null) {
        $input = json_decode(file_get_contents('php://input'), true);
        return $input[$key] ?? $default;
    }

    public function isAjax() {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }
}