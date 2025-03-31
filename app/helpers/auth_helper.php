<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function auth_helper_init() {
    if (!function_exists('check_login')) {
        function check_login() {
            $ci =& get_instance();
            if (!$ci->auth->isLoggedIn()) {
                $ci->redirect('auth/login');
            }
        }
    }

    if (!function_exists('check_role')) {
        function check_role($roles_permitidos = []) {
            $ci =& get_instance();
            $usuario = $ci->auth->user();
            
            if (!$usuario || !in_array($usuario->rol, $roles_permitidos)) {
                show_error('Acceso no autorizado', 403);
                exit;
            }
        }
    }
    
    if (!function_exists('get_user')) {
        function get_user() {
            $ci =& get_instance();
            return $ci->auth->user();
        }
    }
}

// Inicializar el helper
auth_helper_init();