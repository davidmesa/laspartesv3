<?php

require_once 'laspartes_controller.php';

/**
 * Clase que maneja la sección de acerca: ¿Quiénes somos?, Ayuda, Términos y Condiciones, Contáctenos
 */
class Laspartes extends Laspartes_Controller{

    /**
     * Constructor de la clase Acerca
     */
    function __construct(){
        parent::__construct();
    }

    /**
     * Muestra la sección de Ayuda
     */
    function index(){
        redirect("http://www.facebook.com/laspartes");
    }

}