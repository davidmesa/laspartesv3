<?php

/**
 * Clase que maneja la el caso de la redirección hacia la dirección
 * hsphere/local/home/laspartes/laspartes.com/co
 */
class Hsphere extends CI_Controller{

    /**
     * Constructor de la clase Acerca
     */
    function __construct(){
        parent::__construct();
    }

    /**
     * Muestra la sección de ¿Quiénes somos?
     */
    function local(){
        header( 'Location: '.  base_url() ) ;
    }

}