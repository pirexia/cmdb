<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ApiController extends Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('ObjetoModel');
        $this->load->model('CaracteristicaModel');
    }
    
    public function objetos() {
        check_login();
        
        $filtros = $this->input->get();
        $objetos = $this->ObjetoModel->filtrar($filtros);
        
        $this->json($objetos);
    }
    
    public function caracteristicas() {
        check_login();
        
        $tipoObjeto = $this->input->get('tipo');
        $caracteristicas = $this->CaracteristicaModel->getTiposPorTipoObjeto($tipoObjeto);
        
        $this->json($caracteristicas);
    }
    
    public function buscarObjetos() {
        check_login();
        
        $query = $this->input->get('q');
        $objetos = $this->ObjetoModel->buscar($query);
        
        $this->json($objetos);
    }
    
    public function checkIp() {
        check_login();
        
        $ip = $this->input->get('ip');
        $objeto_id = $this->input->get('objeto_id');
        
        $existe = $this->ObjetoModel->ipExiste($ip, $objeto_id);
        
        $this->json([
            'disponible' => !$existe
        ]);
    }
}