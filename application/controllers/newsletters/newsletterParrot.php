<?php

require_once('/hsphere/local/home/laspartes/laspartes.com/application/controllers/laspartes_controller.php');

error_reporting(E_ALL);
ini_set('display_errors', '1');

/**
 * Clase que envía el newsletter de promoción de Parrot
 */
class NewsletterParrot extends Laspartes_Controller 
{ 

    /**
     * Constructor de la clase
     */
    function __construct() { 
        parent::__construct();
    }

    /**
     * Muestra la página principal
     */
    function index() 
    {
        $this->load->model('usuario_model');

        $this->load->helper('date');
        $this->load->helper('mail');

        setlocale(LC_ALL, 'es_ES');
        define("CHARSET", "iso-8859-1");

        $data['fecha'] = strftime("%B %d de %Y");
        $suscritos = $this->usuario_model->dar_usuarios();
//            $suscritos[] = $this->usuario_model->dar_usuario_segun_mail('cabarique.luis@gmail.com');
//            $suscritos[] = $this->usuario_model->dar_usuario_segun_mail('camilohjimenez@gmail.com');
//            $suscritos[] = $this->usuario_model->dar_usuario_segun_mail('felipe.pacheco@laspartes.com.co');

        foreach ($suscritos as $suscrito) 
        {
            $destinatarios = array();
            $destinatario = new stdClass();
            $destinatario->email = $suscrito->email;
            $destinatario->nombres = $suscrito->nombres." ".$suscrito->apellidos;
            $destinatarios[] = $destinatario;  

            ob_start(); 
            $this->load->view('newsletter/promoParrot', $data);
            $contenidoHTML = ob_get_contents();
            ob_end_clean();

            send_mail($destinatarios, "En esta navidad 10% en manos libres Parrot a través de Laspartes.com", $contenidoHTML, "", "");

            echo "Correo enviado a: ".$suscrito->nombres." ".$suscrito->apellidos. " al correo: <strong>".$suscrito->email."</strong><br/>";
        }
    }
}