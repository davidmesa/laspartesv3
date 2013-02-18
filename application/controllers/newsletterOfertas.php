<?php

require_once 'laspartes_controller.php';

error_reporting(E_ALL);
ini_set('display_errors', '1');

/**
 * Clase que maneja la página principal
 */
class NewsletterOfertas extends Laspartes_Controller { 

    /**
     * Constructor de la clase Inicio
     */
    function __construct() { 
        parent::__construct();
    }

    /**
     * Muestra la página principal
     */
    function index($dataP = array()) {
        $hashValidation = $this->input->post('param');
		if(isset($hashValidation) && $this->validarHash($hashValidation)){
            $this->load->model('usuario_model');
            $this->load->helper('date');
            $this->load->helper('mail');
            setlocale(LC_ALL, 'es_ES');
            define("CHARSET", "iso-8859-1");
            $ultimo_cronjob = $this->usuario_model->dar_ultimo_cronjob_tipo('oferta');
            $diff_en_dias = 0;
            if (sizeof($ultimo_cronjob) == 1) {
                $ultima_fecha = $ultimo_cronjob->fecha;
                $diff = abs(strtotime(mdate("%Y-%m-%d")) - strtotime($ultima_fecha));
                $diff_en_dias = ($diff / (60 * 60 * 24));
            }
            if (sizeof($ultimo_cronjob) == 0 || $diff_en_dias > 6):
                $data = $dataP;
                $this->load->model('tip_model');
                $this->load->model('pregunta_model');


                $tips = $this->tip_model->dar_tips_ultimos(3);

                $preguntas = $this->pregunta_model->dar_preguntas_ultimas(3);
                $data['tip'] = $tips;
                $data['preguntas'] = $preguntas;
                $data['fecha'] = strftime("%B %d de %Y");
                $suscritos = $this->usuario_model->dar_usuarios_noticias();
//                 $suscritos[] = $this->usuario_model->dar_usuario_segun_mail('cabarique.luis@gmail.com');
//                 $suscritos[] = $this->usuario_model->dar_usuario_segun_mail('camilohjimenez@gmail.com');
//                 $suscritos[] = $this->usuario_model->dar_usuario_segun_mail('felipe.pacheco@laspartes.com.co');
                foreach ($suscritos as $suscrito) {
                    $destinatarios = array();
                    $destinatario = new stdClass();
                    $destinatario->email = $suscrito->email;
                    $destinatario->nombres = $suscrito->nombres." ".$suscrito->apellidos;
                    $destinatarios[] = $destinatario;  
                    
                    $data['nombre'] = $suscrito->nombres . " " . $suscrito->apellidos;
                    $data['ofertas'] = $this->usuario_model->dar_ofertas_vigentes();



                                ob_start(); 
                                $this->load->view('newsletter/ofertasHTML', $data);
                                $contenidoHTML = ob_get_contents();
                                ob_end_clean();
                                send_mail($destinatarios, "Ofertas y promociones de mantenimiento en Laspartes.com - ".strftime("%B %d de %Y"), $contenidoHTML, "", "");
//                           echo $contenidoHTML;
                                $log = "correo newsletter ofertas enviado a: ".$suscrito->nombres. " al correo: ".$suscrito->email."\n";
                                foreach( $data['ofertas'] as $oferta){
                                    $log .= "oferta: ID: ".$oferta->id_oferta." titulo: ". $oferta->titulo."\n";
                                }
                                $log .="----------------------------------------------------------------------------\n";
                                $this->guardarLog("ofertas", $log); 

                }
                 $this->usuario_model->agregar_cronjob('oferta');
            endif;
            
                }

    }

    
    
    /**
         * Valida que el hash que entra como parámetro se haya generado a partir
         * de la fecha en dos formatos. Se utiliza para verificar que este controlador
         * fue llamado desde el script ubicado en la carpeta "tasks"
         * @param type $hash
         * @return type 
         */
	function validarHash($hash = ''){
		$fecha1 = date('Y-F-d');
		$fecha2 = date('Y-m-d');
		$hash1 = md5($fecha1);
		$hash2 = md5($fecha2);
		$param = $hash1."|".$hash2;
		
		return strcmp($hash, $param) == 0;
	}

}