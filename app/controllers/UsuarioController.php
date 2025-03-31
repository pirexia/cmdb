<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UsuarioController extends Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('UsuarioModel');
        $this->load->model('RolModel');
    }
    
    public function index() {
        check_login();
        check_role(['admin']);
        
        $data['usuarios'] = $this->UsuarioModel->getAllWithRoles();
        $this->load->view('usuarios/index', $data);
    }
    
    public function crear() {
        check_login();
        check_role(['admin']);
        
        if ($this->input->post()) {
            $data = $this->input->post();
            
            $rules = [
                'username' => 'required|unique[usuarios.username]',
                'email' => 'required|email|unique[usuarios.email]',
                'password' => 'required|min:6',
                'confirm_password' => 'required|matches[password]',
                'rol_id' => 'required'
            ];
            
            if ($this->validator->validate($data, $rules)) {
                $data['password_hash'] = password_hash($data['password'], PASSWORD_DEFAULT);
                unset($data['password'], $data['confirm_password']);
                
                if ($this->UsuarioModel->create($data)) {
                    $this->session->setFlashdata('success', 'Usuario creado correctamente');
                    redirect('usuarios');
                } else {
                    $this->session->setFlashdata('error', 'Error al crear el usuario');
                }
            }
        }
        
        $this->load->view('usuarios/form', [
            'modo' => 'crear',
            'roles' => $this->RolModel->getAll()
        ]);
    }
    
    public function editar($id) {
        check_login();
        check_role(['admin']);
        
        $usuario = $this->UsuarioModel->getById($id);
        if (!$usuario) show_404();
        
        if ($this->input->post()) {
            $data = $this->input->post();
            
            $rules = [
                'username' => 'required|unique[usuarios.username,id,'.$id.']',
                'email' => 'required|email|unique[usuarios.email,id,'.$id.']',
                'rol_id' => 'required'
            ];
            
            if (!empty($data['password'])) {
                $rules['password'] = 'required|min:6';
                $rules['confirm_password'] = 'required|matches[password]';
            }
            
            if ($this->validator->validate($data, $rules)) {
                if (!empty($data['password'])) {
                    $data['password_hash'] = password_hash($data['password'], PASSWORD_DEFAULT);
                    unset($data['password'], $data['confirm_password']);
                }
                
                if ($this->UsuarioModel->update($id, $data)) {
                    $this->session->setFlashdata('success', 'Usuario actualizado correctamente');
                    redirect('usuarios');
                } else {
                    $this->session->setFlashdata('error', 'Error al actualizar el usuario');
                }
            }
        }
        
        $this->load->view('usuarios/form', [
            'modo' => 'editar',
            'usuario' => $usuario,
            'roles' => $this->RolModel->getAll()
        ]);
    }
    
    public function eliminar($id) {
        check_login();
        check_role(['admin']);
        
        if ($this->UsuarioModel->delete($id)) {
            $this->session->setFlashdata('success', 'Usuario eliminado correctamente');
        } else {
            $this->session->setFlashdata('error', 'Error al eliminar el usuario');
        }
        
        redirect('usuarios');
    }
}