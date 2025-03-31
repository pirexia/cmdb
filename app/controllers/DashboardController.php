<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DashboardController extends Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('ObjetoModel');
        $this->load->model('FechaModel');
    }
    
    public function index() {
        check_login();
        
        // Objetos próximos a EOL/EOS
        $data['proximos_vencimientos'] = $this->FechaModel->getProximosVencimientos();
        
        // Estadísticas por tipo
        $data['estadisticas_tipo'] = $this->ObjetoModel->getEstadisticasPorTipo();
        
        // Estadísticas por estado
        $data['estadisticas_estado'] = $this->ObjetoModel->getEstadisticasPorEstado();
        
        // Últimos objetos añadidos
        $data['ultimos_objetos'] = $this->ObjetoModel->getUltimos(5);
        
        $this->load->view('dashboard/index', $data);
    }
}