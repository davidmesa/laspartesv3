<?php


/**
 * Clase que maneja la migracion de datos al CRM
 */
class OrdenCompra extends CI_Controller {

    /**
     * Constructor de la clase Usuario
     */
    function __construct() {
        parent::__construct();
    }

    function index() {
    }

    /**
     * Muestra el iFrame para realizar cotizaciones
     * @return [type] [description]
     */
    function mostrar_cotizaciones(){
        $this->load->view('CRM/cotizacion_view');
    }

}