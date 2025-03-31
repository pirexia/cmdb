<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Session {
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function set($key, $value) {
        $_SESSION[$key] = $value;
    }

    public function get($key) {
        return $_SESSION[$key] ?? null;
    }

    public function unset($key) {
        unset($_SESSION[$key]);
    }

    public function destroy() {
        session_destroy();
    }

    public function setFlashdata($key, $value) {
        $_SESSION['flash_' . $key] = $value;
    }

    public function flashdata($key) {
        $value = $_SESSION['flash_' . $key] ?? null;
        unset($_SESSION['flash_' . $key]);
        return $value;
    }
}