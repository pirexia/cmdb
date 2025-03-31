<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Database {
    private $connection;
    private $query;
    private $config;

    public function __construct() {
        // Cargar configuración correctamente
        $this->config = require __DIR__ . '/../config/database.php';
        $this->config = $this->config['default']; // Acceder al grupo correcto
        $this->connect();
    }

    private function connect() {
        $dsn = "mysql:host={$this->config['hostname']};dbname={$this->config['database']};charset={$this->config['char_set']}";
        
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES {$this->config['char_set']}"
        ];

        try {
            $this->connection = new PDO(
                $dsn,
                $this->config['username'],
                $this->config['password'],
                $options
            );
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }

    public function query($sql, $params = []) {
        $this->query = $this->connection->prepare($sql);
        $this->query->execute($params);
        return $this;
    }

    public function result() {
        return $this->query->fetchAll();
    }

    public function row() {
        return $this->query->fetch();
    }

    public function insert($table, $data) {
        $keys = array_keys($data);
        $fields = implode(', ', $keys);
        $placeholders = ':' . implode(', :', $keys);
        
        $sql = "INSERT INTO $table ($fields) VALUES ($placeholders)";
        $this->query($sql, $data);
        
        return $this->connection->lastInsertId();
    }

    public function update($table, $data, $where) {
        $set = '';
        foreach ($data as $key => $value) {
            $set .= "$key = :$key, ";
        }
        $set = rtrim($set, ', ');
        
        $sql = "UPDATE $table SET $set WHERE $where";
        $this->query($sql, $data);
        
        return $this->query->rowCount();
    }

    public function delete($table, $where, $params = []) {
        $sql = "DELETE FROM $table WHERE $where";
        $this->query($sql, $params);
        
        return $this->query->rowCount();
    }

    public function beginTransaction() {
        return $this->connection->beginTransaction();
    }

    public function commit() {
        return $this->connection->commit();
    }

    public function rollBack() {
        return $this->connection->rollBack();
    }
}