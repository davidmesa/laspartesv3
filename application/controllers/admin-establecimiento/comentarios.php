<?php

/**
 * Clase que maneja los establecimientos
 */
class Comentarios extends CI_Controller{

    /**
     * Constructor de la clase Establecimiento
     */
    function __construct(){
        parent::__construct();
        $esta_registrado = $this->session->userdata('esta_registrado');
        if(!isset($esta_registrado)||!$esta_registrado||$this->session->userdata('tipo')!=20)
            redirect(base_url().'admin-establecimiento/inicio', 'refresh');
        
    }
    
    /**
     * Da la lista de establecimientos
     * @return array $establecimientos
     */
    function _ver_establecimientos(){
        $id_usuario = $this->session->userdata('id_usuario');
        $this->load->model('establecimiento_model');
        $data['establecimientos'] = $this->establecimiento_model->dar_establecimientos_usuario($id_usuario);
        return $data;
    }

    /**
     * Muestra las ventas que ha realizado el establecimiento
     */
    function index(){
        $data = $this->_ver_establecimientos();
        $this->load->view('admin-establecimiento/comentarios/mis_comentarios_lista_view', $data);
    }
    
    /**
     * Da detalles de los comentarios de un establecimiento
     * @param int $id_establecimiento
     * @return array con $establecimiento y $zonas
     */
    function _ver_establecimiento_comentarios($id_establecimiento){
        $this->load->model('establecimiento_model');
        $data['comentarios'] = $this->establecimiento_model->dar_establecimiento_comentarios($id_establecimiento);
        return $data;
    }
    
    /**
     * Verifica si un usuario puede tomar acción en el establecimiento
     * @param int $id_establecimiento
     * @return bool $tiene_permiso
     */
    function _verificar_usuario_permiso_establecimiento($id_establecimiento){
        $this->load->model('establecimiento_model');
        $resultado = $this->establecimiento_model->esta_asignado_usuario_establecimiento($this->session->userdata('id_usuario'), $id_establecimiento);
        if($resultado == 1)
            return TRUE;
        else
            return FALSE;
    }
    
    /**
     * Muestra las ventas de un establecimiento
     */
    function ver_comentarios(){
        $id_establecimiento = $this->uri->segment(4);
        if($this->_verificar_usuario_permiso_establecimiento($id_establecimiento)){
            $data = $this->_ver_establecimiento_comentarios($id_establecimiento);
            $this->load->view('admin-establecimiento/comentarios/mis_comentarios_detalle_view', $data);
        }
    }
    
    /**
     * cambia el estado de un comentario de activo a inactivo
     */
    function cambiar_estado_ajax(){
         $id_comentario = $this->input->get_post('id_comentario', TRUE);
        $estado = $this->input->get_post('estado', TRUE);
        $this->load->model('establecimiento_model'); 
        $this->establecimiento_model->cambiar_estado_comentario_establecimiento($id_comentario, $estado);
    }
    
}