<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth {
    private $session;
    private $db;

    public function __construct() {
        $this->session = new Session();
        $this->db = new Database();
    }

    public function login($username, $password) {
        $user = $this->db->query("SELECT * FROM usuarios WHERE username = ?", [$username])->row();
        
        if ($user && password_verify($password, $user->password_hash)) {
            $this->session->set('user_id', $user->id);
            $this->session->set('username', $user->username);
            $this->session->set('rol', $user->rol_id);
            $this->session->set('logged_in', true);
            return true;
        }
        
        return false;
    }

    public function logout() {
        $this->session->destroy();
    }

    public function isLoggedIn() {
        return $this->session->get('logged_in') === true;
    }

    public function user() {
        if (!$this->isLoggedIn()) return null;
        
        return $this->db->query("
            SELECT u.*, r.nombre as rol 
            FROM usuarios u
            JOIN roles r ON r.id = u.rol_id
            WHERE u.id = ?
        ", [$this->session->get('user_id')])->row();
    }

    public function hasRole($role) {
        $user = $this->user();
        return $user && $user->rol === $role;
    }
}