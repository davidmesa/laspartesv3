<?php

require_once 'laspartes_controller.php';

/**
 * Clase que maneja la página principal
 */
class Inicio extends Laspartes_Controller{

    /**
     * Constructor de la clase Inicio
     */
    function __construct(){
        parent::__construct();
        setlocale(LC_ALL, 'es_ES');
    }

    /**
     * Muestra la página principal
     */
    function index(){
        $this->load->model('autoparte_model');
        $this->load->model('establecimiento_model');
        $this->load->model('pregunta_model');
        $data['establecimientos'] = $this->establecimiento_model->dar_top_establecimientos(5);
        $data['preguntas'] = $this->pregunta_model->dar_preguntas_paginacion_filtros(5, 0);
        $data['metaDescripcion'] = 'Registra la información de tu carro y te avisamos qué debes tener en cuenta, cuándo tienes que hacerlo, y quiénes pueden ayudarte con el adecuado mantenimiento. Información sobre autopartes, talleres, mecánica automotriz, ofertas y promociones en Laspartes.com.';
        $data['titulo'] = 'Laspartes.com :: Todo para tu vehículo';
        $data['breadcrumb'] = 'Inicio';
        $data['header_view'] = 'inicio/header/inicio_view';
        $data['navegacion_view'] = 'inicio';
        $data['contenido_view'] = 'inicio/inicio_view';
        $this->load->view('template/template', $data);
    }
    	
}