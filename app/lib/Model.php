<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model {
    protected $db;
    protected $table;
    protected $primaryKey = 'id';

    public function __construct() {
        $this->db = new Database();
    }

    public function all() {
        return $this->db->query("SELECT * FROM {$this->table}")->result();
    }

    public function find($id) {
        return $this->db->query("SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ?", [$id])->row();
    }

    public function where($conditions, $params = []) {
        $where = implode(' AND ', array_map(function($col) {
            return "$col = ?";
        }, array_keys($conditions)));
        
        return $this->db->query("SELECT * FROM {$this->table} WHERE $where", array_values($conditions))->result();
    }

    public function create($data) {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data) {
        return $this->db->update($this->table, $data, "{$this->primaryKey} = :{$this->primaryKey}", [
            $this->primaryKey => $id
        ]);
    }

    public function delete($id) {
        return $this->db->delete($this->table, "{$this->primaryKey} = ?", [$id]);
    }
}