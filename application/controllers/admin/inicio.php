<?php

/**
 * Clase que maneja el inicio del admin
 */
class Inicio extends CI_Controller{

    /**
     * Constructor de la clase Inicio
     */
    function __construct(){
        parent::__construct();
    }

    /**
     * Muestra la página principal
     */
    function _pagina_principal(){
        $this->load->view('admin/inicio_view');
    }

    /**
     * Muestra la página principal o página de login de acuerdo a la sesión
     */
    function index(){
        $esta_registrado = $this->session->userdata('esta_registrado');
        if(!isset($esta_registrado)||!$esta_registrado||$this->session->userdata('tipo')!=10)
            $this->load->view('admin/login_view');
        else
            $this->_pagina_principal();
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
                $this->load->view('admin/login_view', $data);
            }
            else if($this->session->userdata('tipo')!=10){
                $data['error'] = 'Correo electrónico o contraseña inválidos.';
                $this->session->unset_userdata('esta_registrado');
                $this->session->sess_destroy();
                $this->load->view('admin/login_view', $data);
            }
            else
                $this->load->view('admin/inicio_view');
        }
    }
}