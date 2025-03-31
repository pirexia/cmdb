<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ClaseController extends Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('ClaseModel');
    }
    
    public function index() {
        check_login();
        check_role(['admin']);
        
        $data['clases'] = $this->ClaseModel->getAll();
        $this->load->view('clases/index', $data);
    }
    
    public function crear() {
        check_login();
        check_role(['admin']);
        
        if ($this->input->post()) {
            $data = $this->input->post();
            
            if ($this->ClaseModel->create($data)) {
                $this->session->setFlashdata('success', 'Clase creada correctamente');
                redirect('clases');
            } else {
                $this->session->setFlashdata('error', 'Error al crear la clase');
            }
        }
        
        $this->load->view('clases/form', ['modo' => 'crear']);
    }
    
    public function editar($id) {
        check_login();
        check_role(['admin']);
        
        $clase = $this->ClaseModel->getById($id);
        if (!$clase) show_404();
        
        if ($this->input->post()) {
            $data = $this->input->post();
            
            if ($this->ClaseModel->update($id, $data)) {
                $this->session->setFlashdata('success', 'Clase actualizada correctamente');
                redirect('clases');
            } else {
                $this->session->setFlashdata('error', 'Error al actualizar la clase');
            }
        }
        
        $this->load->view('clases/form', [
            'modo' => 'editar',
            'clase' => $clase
        ]);
    }
    
    public function eliminar($id) {
        check_login();
        check_role(['admin']);
        
        if ($this->ClaseModel->delete($id)) {
            $this->session->setFlashdata('success', 'Clase eliminada correctamente');
        } else {
            $this->session->setFlashdata('error', 'Error al eliminar la clase');
        }
        
        redirect('clases');
    }
}