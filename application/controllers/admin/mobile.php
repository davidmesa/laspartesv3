<?php

/**
 * Clase que maneja los usuarios
 */
class Mobile extends CI_Controller {

    /**
     * Constructor de la clase Usuario
     */
    function __construct() {
        parent::__construct();
        $esta_registrado = $this->session->userdata('esta_registrado');
        if(!isset($esta_registrado)||!$esta_registrado||$this->session->userdata('tipo')!=10)
            redirect(base_url().'admin/inicio', 'refresh');
    }
    
    /**
     * Muestra la lista de usuarios
     */
    function index() {
        //cargar los usuarios que están conectados
        $data['usuarios'] = $this->ver_usuarios_conectados();
        $this->load->view('admin/mobile/chats_lista_view', $data);
    }
    
    /**
     * Carga los usuarios que están conectados en el momento que se carga la página
     */
    function ver_usuarios_conectados(){
        $this->load->model('mobile/usuario_model');
        $usuarios= $this->usuario_model->ver_usuarios_conectados();
        $nuevosUsuarios = Array();
        foreach ($usuarios as $usuario) {
            $nuevoUsuario = $usuario;
            $nuevoUsuario->chats = $this->usuario_model->ver_chats_activos($usuario->id_usuario);
            $nuevosUsuarios[] = $nuevoUsuario;
        }
        return $nuevosUsuarios;
    }
    
    /**
     * Da los nuevos chats en el sistema
     * @return type
     */
    function dar_nuevos_chats(){
        $this->load->model('mobile/usuario_model');
        $id_usuarios= $this->input->post('id_usuarios', TRUE); 
        echo json_encode(array('status' => true, 'ids' => $this->usuario_model->dar_nuevos_chats($id_usuarios)));
    }
}