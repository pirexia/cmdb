<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AuthController extends Controller {
    /*public function __construct() {
        parent::__construct();
        $this->load->helper('auth');
    }*/

    protected $UsuarioModel;

    public function __construct() {
        parent::__construct();
        $this->UsuarioModel = $this->load->model('UsuarioModel');
		$this->load->helper('auth');
	}

    /**
     * Muestra el formulario de login y maneja el proceso de autenticación
     */
	public function login() {
		if ($this->auth->isLoggedIn()) {
			redirect('dashboard');
		}

		if ($this->input->post()) {
			$username = $this->input->post('username');
			$password = $this->input->post('password');

			try {
				// Paso 1: Obtener usuario de la base de datos
				$user = $this->UsuarioModel->getByUsername($username);

				if (!$user) {
					throw new Exception("Usuario no encontrado");
				}

				// Paso 2: Verificar si la cuenta está activa
				if (!$user->activo) {
					throw new Exception("Cuenta desactivada");
				}

				// Paso 3: Validar hash (Versión corregida)
				if ($this->verifyPassword($password, $user->password_hash)) {
					// Paso 4: Iniciar sesión
					$this->auth->loginUser($user);
					
					// Redirección post-login
					$redirectUrl = $this->session->get('redirect_url') ?? 'dashboard';
					$this->session->unset('redirect_url');
					redirect($redirectUrl);
				} else {
					throw new Exception("Contraseña incorrecta");
				}

			} catch (Exception $e) {
				// Registrar error y mostrar mensaje
				error_log("Error de autenticación: " . $e->getMessage());
				$this->session->setFlashdata('error', $e->getMessage());
			}
		}

		$this->load->view('auth/login');
	}

	// Nuevo método para verificación de contraseña
	private function verifyPassword($inputPassword, $storedHash) {
		// Si usaste SHA2 en SQL
		if (hash('sha256', $inputPassword) === $storedHash) {
			return true;
		}
		
		// Si usaste password_hash() de PHP
		if (password_verify($inputPassword, $storedHash)) {
			return true;
		}
		error_log("Contraseña recibida: $inputPassword");
		error_log("Hash almacenado: $storedHash");
		error_log("SHA256(input): " . hash('sha256', $inputPassword));
		error_log("password_verify result: " . password_verify($inputPassword, $storedHash));
		
		return false;
	}

    /**
     * Cierra la sesión del usuario
     */
    public function logout() {
        $this->auth->logout();
        $this->session->setFlashdata('success', 'Sesión cerrada correctamente');
        redirect('auth/login');
    }

    /**
     * Muestra el formulario de recuperación de contraseña
     */
    public function forgot_password() {
        if ($this->input->post()) {
            $email = $this->input->post('email');
            
            try {
                $this->auth->sendPasswordReset($email);
                $this->session->setFlashdata('success', 'Instrucciones enviadas a tu correo');
                redirect('auth/login');
            } catch (Exception $e) {
                $this->session->setFlashdata('error', $e->getMessage());
            }
        }
        
        $this->load->view('auth/forgot-password');
    }

    /**
     * Maneja el reset de contraseña
     */
    public function reset_password($token = null) {
        if (!$token) show_404();

        if ($this->input->post()) {
            $password = $this->input->post('password');
            
            try {
                if ($this->auth->resetPassword($token, $password)) {
                    $this->session->setFlashdata('success', 'Contraseña actualizada correctamente');
                    redirect('auth/login');
                }
            } catch (Exception $e) {
                $this->session->setFlashdata('error', $e->getMessage());
            }
        }

        $this->load->view('auth/reset-password', ['token' => $token]);
    }
}