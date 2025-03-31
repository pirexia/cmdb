<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ObjetoController extends Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('ObjetoModel');
        $this->load->model('CaracteristicaModel');
        $this->load->model('IpModel');
        $this->load->model('FechaModel');
        $this->load->model('AsociacionModel');
        $this->load->model('ClaseModel');
    }
    
    public function index() {
        check_login();
        
        $filtros = $this->input->get();
        $data['objetos'] = $this->ObjetoModel->filtrar($filtros);
        $data['clases'] = $this->ClaseModel->getAll();
        $data['filtros'] = $filtros;
        
        $this->load->view('objetos/index', $data);
    }
    
    public function crear() {
        check_login();
        check_role(['admin', 'editor']);
        
        if ($this->input->post()) {
            $this->guardarObjeto();
        }
        
        $this->load->view('objetos/form', [
            'modo' => 'crear',
            'tipos' => $this->ObjetoModel->getTipos(),
            'clases' => $this->ClaseModel->getAll(),
            'tipos_fecha' => $this->FechaModel->getTipos(),
            'tipos_caracteristicas' => $this->CaracteristicaModel->getTipos(),
            'objetos' => $this->ObjetoModel->getAll() // Para relaciones
        ]);
    }
    
    public function editar($id) {
        check_login();
        check_role(['admin', 'editor']);
        
        $objeto = $this->ObjetoModel->getById($id);
        if (!$objeto) show_404();
        
        if ($this->input->post()) {
            $this->guardarObjeto($id);
        }
        
        $this->load->view('objetos/form', [
            'modo' => 'editar',
            'objeto' => $objeto,
            'tipos' => $this->ObjetoModel->getTipos(),
            'clases' => $this->ClaseModel->getAll(),
            'ips' => $this->IpModel->getByObjeto($id),
            'fechas' => $this->FechaModel->getByObjeto($id),
            'caracteristicas' => $this->CaracteristicaModel->getByObjeto($id),
            'asociaciones' => $this->AsociacionModel->getByObjeto($id),
            'tipos_fecha' => $this->FechaModel->getTipos(),
            'tipos_caracteristicas' => $this->CaracteristicaModel->getTipos(),
            'objetos' => $this->ObjetoModel->getAll() // Para relaciones
        ]);
    }
    
    public function ver($id) {
        check_login();
        
        $objeto = $this->ObjetoModel->getById($id);
        if (!$objeto) show_404();
        
        $this->load->view('objetos/ver', [
            'objeto' => $objeto,
            'ips' => $this->IpModel->getByObjeto($id),
            'fechas' => $this->FechaModel->getByObjeto($id),
            'caracteristicas' => $this->CaracteristicaModel->getByObjeto($id),
            'asociaciones' => $this->AsociacionModel->getByObjeto($id),
            'imagenes' => $this->ObjetoModel->getImagenes($id)
        ]);
    }
    
    public function eliminar($id) {
        check_login();
        check_role(['admin']);
        
        if ($this->ObjetoModel->delete($id)) {
            $this->session->setFlashdata('success', 'Objeto eliminado correctamente');
        } else {
            $this->session->setFlashdata('error', 'Error al eliminar el objeto');
        }
        
        redirect('objetos');
    }
    
    private function guardarObjeto($id = null) {
        $this->db->beginTransaction();
        
        try {
            // Datos principales del objeto
            $objetoData = [
                'nombre' => $this->input->post('nombre'),
                'descripcion' => $this->input->post('descripcion'),
                'tipo' => $this->input->post('tipo'),
                'clase_id' => $this->input->post('clase_id'),
                'estado' => $this->input->post('estado'),
                'ubicacion' => $this->input->post('ubicacion'),
                'planta' => $this->input->post('planta'),
                'modulo' => $this->input->post('modulo'),
                'rack' => $this->input->post('rack'),
                'u' => $this->input->post('u'),
                'brs' => $this->input->post('brs') ? 1 : 0,
                'notas' => $this->input->post('notas')
            ];
            
            // Guardar objeto principal
            if ($id) {
                $objetoData['id'] = $id;
                $this->ObjetoModel->update($objetoData);
            } else {
                $objetoData['usuario_creador_id'] = $this->auth->user()->id;
                $id = $this->ObjetoModel->create($objetoData);
            }
            
            // Guardar IPs
            $ips = $this->input->post('ips') ?: [];
            $this->IpModel->guardarIPs($id, $ips);
            
            // Guardar fechas importantes
            $fechas = $this->input->post('fechas') ?: [];
            $this->FechaModel->guardarFechas($id, $fechas);
            
            // Guardar características
            $caracteristicas = $this->input->post('caracteristicas') ?: [];
            $this->CaracteristicaModel->guardarCaracteristicas($id, $caracteristicas);
            
            // Guardar relaciones
            $relaciones = $this->input->post('relaciones') ?: [];
            $this->AsociacionModel->guardarAsociaciones($id, $relaciones);
            
            // Guardar imágenes
            if (!empty($_FILES['imagenes'])) {
                $this->guardarImagenes($id);
            }
            
            $this->db->commit();
            
            $this->session->setFlashdata('success', 'Objeto guardado correctamente');
            redirect('objetos/editar/' . $id);
            
        } catch (Exception $e) {
            $this->db->rollBack();
            $this->session->setFlashdata('error', 'Error al guardar el objeto: ' . $e->getMessage());
        }
    }
    
    private function guardarImagenes($objeto_id) {
        $uploadDir = '../uploads/objetos/' . $objeto_id . '/';
        
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        foreach ($_FILES['imagenes']['tmp_name'] as $key => $tmp_name) {
            if ($_FILES['imagenes']['error'][$key] === UPLOAD_ERR_OK) {
                $fileName = basename($_FILES['imagenes']['name'][$key]);
                $filePath = $uploadDir . $fileName;
                
                if (move_uploaded_file($tmp_name, $filePath)) {
                    $this->ObjetoModel->agregarImagen($objeto_id, [
                        'ruta_imagen' => 'uploads/objetos/' . $objeto_id . '/' . $fileName,
                        'nombre_archivo' => $fileName,
                        'tamano' => $_FILES['imagenes']['size'][$key],
                        'tipo_mime' => $_FILES['imagenes']['type'][$key],
                        'usuario_subio_id' => $this->auth->user()->id
                    ]);
                }
            }
        }
    }
    
    public function eliminarImagen($objeto_id, $imagen_id) {
        check_login();
        check_role(['admin', 'editor']);
        
        $imagen = $this->ObjetoModel->getImagen($imagen_id);
        
        if ($imagen && $imagen->objeto_id == $objeto_id) {
            $filePath = '../' . $imagen->ruta_imagen;
            
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            
            $this->ObjetoModel->eliminarImagen($imagen_id);
            $this->session->setFlashdata('success', 'Imagen eliminada correctamente');
        } else {
            $this->session->setFlashdata('error', 'Imagen no encontrada');
        }
        
        redirect('objetos/editar/' . $objeto_id);
    }
}