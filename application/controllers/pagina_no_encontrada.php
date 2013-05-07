<?php

require_once 'laspartes_controller.php';

/**
 * Clase que maneja la sección de acerca: ¿Quiénes somos?, Ayuda, Términos y Condiciones, Contáctenos
 */
class Pagina_no_encontrada extends Laspartes_Controller{

    /**
     * Constructor de la clase Acerca
     */
    function __construct(){
        parent::__construct();
    }
    
    function index() {
        $data['titulo'] = 'Página no Encontrada';
        $data['breadcrumb'] = '<div><a href="' . base_url() . '">Inicio</a></div> <div class="div-breadcrumb-espaciador"></div> <div>Página no encontrada</div>';
        $data['header_view'] = 'error/404/header/404_view';
        $data['navegacion_view'] = '';
        $data['contenido_view'] = 'error/404/404_view';
        $this->load->view('template/template', $data);
    }
}