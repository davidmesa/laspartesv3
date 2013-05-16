<?php

require_once('/hsphere/local/home/laspartes/laspartes.com/application/controllers/laspartes_controller.php');

/**
 * Clase que maneja la migracion de datos al CRM
 */
class Migrar extends Laspartes_Controller {

    /**
     * Constructor de la clase Usuario
     */
    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->load->model('usuario_model');
        $this->load->model('vehiculo_model');

        // $usuarios = $this->usuario_model->dar_usuarios();
        // $this->crm->migrar_usuarios($usuarios);
        $marcaslineas = $this->vehiculo_model->dar_vehiculos();
        $this->crm->migrar_marcalinea($marcaslineas);
        $vehiculos = $this->usuario_model->dar_usuarios_vehiculos();
        $this->crm->migrar_usuarios_vehiculos($vehiculos);
        $compras = $this->usuario_model->dar_items_compras_usuarios();
        $this->crm->migrar_usuarios_compras($compras);
    }

}