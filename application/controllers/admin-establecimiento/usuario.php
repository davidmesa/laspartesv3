<?php

/**
 * Clase que maneja los usuarios
 */
class Usuario extends CI_Controller{

    /**
     * Constructor de la clase Usuario
     */
    function __construct(){
        parent::__construct();
        $esta_registrado = $this->session->userdata('esta_registrado');


    }
    
    /**
     * Destruye la sesión y redirecciona a la página principal
     */
    function cerrar_sesion(){
        $this->session->unset_userdata('esta_registrado');
        $this->session->sess_destroy();
        $data['confirmacion'] = 'Sesión cerrada con éxito.';
        $this->load->view('admin-establecimiento/login_view', $data);
    }

    /**
     * Valida el correo electrónico y contraseña para iniciar sesión
     */
    function validar_usuario(){
        $this->load->library('form_validation');
        $reglas = array(
            array(
                'field' => 'email',
                'label' => 'correo electrónico',
                'rules' => 'trim|required|valid_email|xss_clean'
            ),
            array(
                'field' => 'contrasena',
                'label' => 'contraseña',
                'rules' => 'trim|required|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);

        if(!$this->form_validation->run())
            $this->load->view('admin/login_view');
        else{
            $this->load->model('usuario_model');
            $email = strtolower($this->input->post('email', TRUE));
            $contrasena = sha1($this->input->post('contrasena', TRUE));
            $resultado = $this->usuario_model->validar_usuario($email, $contrasena);
            
            if(!$resultado){
                $data['error'] = 'Correo electrónico o contraseña inválidos.';
                $this->load->view('admin-establecimiento/login_view', $data);
            }
            else if($this->session->userdata('tipo')!=20){
                $data['error'] = 'Correo electrónico o contraseña inválidos.';
                $this->session->unset_userdata('esta_registrado');
                $this->session->sess_destroy();
                $this->load->view('admin-establecimiento/login_view', $data);
            }
            else
                $this->load->view('admin-establecimiento/inicio_view');
        }
    }
}