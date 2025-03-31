<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Validator {
    private $errors = [];
    private $data;

    public function validate($data, $rules) {
        $this->errors = [];
        $this->data = $data;

        foreach ($rules as $field => $validations) {
            $validations = explode('|', $validations);
            $value = $data[$field] ?? null;

            foreach ($validations as $validation) {
                $params = explode(':', $validation);
                $method = $params[0];
                $params = isset($params[1]) ? explode(',', $params[1]) : [];

                if (!$this->$method($field, $value, $params)) {
                    break;
                }
            }
        }

        return empty($this->errors);
    }

    public function errors() {
        return $this->errors;
    }

    private function required($field, $value, $params) {
        if (empty($value)) {
            $this->errors[$field] = "El campo $field es requerido";
            return false;
        }
        return true;
    }

    private function email($field, $value, $params) {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field] = "El campo $field debe ser un email válido";
            return false;
        }
        return true;
    }

    private function min($field, $value, $params) {
        if (strlen($value) < $params[0]) {
            $this->errors[$field] = "El campo $field debe tener al menos {$params[0]} caracteres";
            return false;
        }
        return true;
    }

    // Más métodos de validación...
}