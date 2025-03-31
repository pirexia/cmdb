<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PublicController extends Controller {
    protected $ObjetoModel;

    public function __construct() {
        parent::__construct();
        $this->ObjetoModel = $this->load->model('ObjetoModel');
    }

    public function index() {
    // Redirigir a login si no está autenticado
    if (!$this->auth->isLoggedIn()) {
        redirect('auth/login');
    }
    // Si está logueado mostrar dashboard privado
    redirect('dashboard');
	}

    private function publicDashboard() {
        try {
            $data = [
                'total_objetos' => $this->ObjetoModel->countAll(),
                'objetos_activos' => $this->ObjetoModel->countByEstado('activo'),
                'proximos_vencimientos' => $this->ObjetoModel->getProximosVencimientosPublicos(5)
            ];
            
            $this->load->view('public/dashboard', $data);
        } catch (Exception $e) {
            $this->load->view('public/error', [
                'mensaje' => 'Error al cargar los datos del dashboard: ' . $e->getMessage()
            ]);
        }
    }

    public function contacto() {
        if ($this->input->post()) {
            $reglas = [
                'nombre' => 'required',
                'email' => 'required|email',
                'mensaje' => 'required|min:10'
            ];
            
            if ($this->validator->validate($this->input->post(), $reglas)) {
                // Lógica para enviar el correo
                $this->session->setFlashdata('success', 'Mensaje enviado correctamente');
                redirect('contacto');
            }
        }
        
        $this->load->view('public/contacto', [
            'errors' => $this->validator->errors()
        ]);
    }

    public function privacidad() {
        $this->load->view('public/privacidad');
    }

    public function terminos() {
        $this->load->view('public/terminos');
    }

    public function notFound() {
        $this->load->view('public/404');
    }

    public function mantenimiento() {
        if (!file_exists('../app/config/maintenance.lock') && !$this->auth->hasRole('admin')) {
            redirect('');
        }
        $this->load->view('public/mantenimiento');
    }

    public function apiStatus() {
        try {
            $status = [
                'status' => 'online',
                'version' => '1.0.0',
                'timestamp' => date('Y-m-d H:i:s'),
                'objects_count' => $this->ObjetoModel->countAll(),
                'maintenance' => file_exists('../app/config/maintenance.lock')
            ];
            
            $this->json($status);
        } catch (Exception $e) {
            $this->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function widgetVencimientos() {
        try {
            $limit = $this->input->get('limit') ?: 3;
            $vencimientos = $this->ObjetoModel->getProximosVencimientosPublicos($limit);
            
            $this->load->view('public/widgets/vencimientos', [
                'vencimientos' => $vencimientos
            ]);
        } catch (Exception $e) {
            echo "Error al cargar el widget";
        }
    }

    public function widgetEstado() {
        try {
            $estados = $this->ObjetoModel->getEstadisticasEstadoPublicas();
            
            $this->load->view('public/widgets/estado', [
                'estados' => $estados
            ]);
        } catch (Exception $e) {
            echo "Error al cargar el widget";
        }
    }
}