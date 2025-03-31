<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UsuarioModel extends Model {
    protected $table = 'usuarios';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'username', 
        'password_hash', 
        'email', 
        'rol_id', 
        'activo', 
        'ultimo_login', 
        'fecha_creacion'
    ];

    /**
     * Obtiene un usuario por su nombre de usuario
     */
    public function getByUsername($username) {
        return $this->db->query(
            "SELECT * FROM {$this->table} 
            WHERE username = :username 
            LIMIT 1",
            [':username' => $username]
        )->row();
    }

    /**
     * Obtiene un usuario por su email
     */
    public function getByEmail($email) {
        return $this->db->query(
            "SELECT * FROM {$this->table} 
            WHERE email = :email 
            LIMIT 1",
            [':email' => $email]
        )->row();
    }

    /**
     * Actualiza la contraseña de un usuario
     */
    public function actualizarPassword($usuarioId, $nuevoHash) {
        return $this->db->update(
            $this->table,
            ['password_hash' => $nuevoHash],
            "{$this->primaryKey} = :id",
            [':id' => $usuarioId]
        );
    }

    /**
     * Verifica si un username ya existe
     */
    public function usernameExiste($username, $excluirId = null) {
        $sql = "SELECT COUNT(*) as total 
                FROM {$this->table} 
                WHERE username = :username";
        
        $params = [':username' => $username];
        
        if ($excluirId) {
            $sql .= " AND {$this->primaryKey} != :id";
            $params[':id'] = $excluirId;
        }
        
        $result = $this->db->query($sql, $params)->row();
        return $result->total > 0;
    }

    /**
     * Verifica si un email ya existe
     */
    public function emailExiste($email, $excluirId = null) {
        $sql = "SELECT COUNT(*) as total 
                FROM {$this->table} 
                WHERE email = :email";
        
        $params = [':email' => $email];
        
        if ($excluirId) {
            $sql .= " AND {$this->primaryKey} != :id";
            $params[':id'] = $excluirId;
        }
        
        $result = $this->db->query($sql, $params)->row();
        return $result->total > 0;
    }

    /**
     * Crea un nuevo usuario
     */
    public function crearUsuario($data) {
        return $this->db->insert($this->table, $data);
    }

    /**
     * Actualiza el último login
     */
    public function actualizarUltimoLogin($usuarioId) {
        return $this->db->update(
            $this->table,
            ['ultimo_login' => date('Y-m-d H:i:s')],
            "{$this->primaryKey} = :id",
            [':id' => $usuarioId]
        );
    }
}