<?php

require_once 'laspartes_controller.php';



/**
 * Controlador que genera el newsletter de noticias
 */
class NewsletterNoticias extends Laspartes_Controller{

	/**
	 * Constructor de la clase Inicio
	 */
	function __construct(){
		parent::__construct();
	}

	/**
	 * Genera el newsletter de noticias a partir de la info en la base de datos.
         * El template se encuentra en "newsletter/noticiasHTML". 
         * Por seguridad, recibe un hash que se genera desde un archivo en php ubicado
         * en la carpeta "tasks". Además guarda la fecha del último newsletter que 
         * generó y sólo deja generar el newsletter después del 6to día que se
         * generó el anterior.
	 */
	function index($dataP = array()){
		$hashValidation = $this->input->post('param');
		if(isset($hashValidation) && $this->validarHash($hashValidation)){
                        setlocale(LC_ALL,'es_ES');
                        define("CHARSET", "iso-8859-1"); 
			$this->load->model('usuario_model');
                        $this->load->helper('date');
                        $this->load->helper('mail');
			$data = $dataP;
			$this->load->model('tip_model');
			$this->load->model('noticia_model');
                        $ultimo_cronjob = $this->usuario_model->dar_ultimo_cronjob_tipo('newsletter');
                        $diff_en_dias = 0;
                        if(sizeof($ultimo_cronjob)==1){
                            $ultima_fecha = $ultimo_cronjob->fecha;
                            $diff = abs(strtotime(mdate("%Y-%m-%d")) - strtotime($ultima_fecha));
                            $diff_en_dias = ($diff/(60*60*24));
                        }
                        if (sizeof($ultimo_cronjob)== 0 || $diff_en_dias > 6 ):

                            $tips = $this->tip_model->dar_tips_ultimos(2);
                            $noticias = $this->noticia_model->dar_noticias_ultimas(2);
                            $data['tip'] = $tips;
                            $data['noticia'] = $noticias;
                            $data['fecha'] = strftime("%B %d de %Y");

                            ob_start();
                            $this->load->view('newsletter/noticiasHTML', $data);
                            $contenidoHTML = ob_get_contents();
                            ob_end_clean();

                            $destinatarios = array();
                            $suscritos = $this->usuario_model->dar_usuarios_noticias();
                            foreach($suscritos as $suscrito){
                                    $destinatario = new stdClass(); 
                                    $destinatario->email = $suscrito->email;
                                    $destinatario->nombres = $suscrito->nombres." ".$suscrito->apellidos;
                                    $destinatarios[] = $destinatario;  
                                    $stringData = "correo newsletter noticias enviado a: ".$destinatario->nombres. " al correo: ".$destinatario->email."\n";
                                    $this->guardarLog("noticias", $stringData);
                                    echo $stringData;
                            } 
                            send_mail($destinatarios, "Noticias y Tips sobre tu vehículo - ".strftime("%B %d de %Y"), $contenidoHTML, "", "");
                            $this->usuario_model->agregar_cronjob('newsletter');
                        endif; 
                }
	}
        
        function newsletter_nomail(){
            setlocale(LC_ALL,'es_ES');
                        define("CHARSET", "iso-8859-1"); 
			$this->load->model('usuario_model');
                        $this->load->helper('date');
                        $this->load->helper('mail');
			$data = $dataP;
			$this->load->model('tip_model');
			$this->load->model('noticia_model');
			$this->load->model('pregunta_model');
                        $ultimo_cronjob = $this->usuario_model->dar_ultimo_cronjob_tipo('newsletter');
                        $diff_en_dias = 0;
                        if(sizeof($ultimo_cronjob)==1){
                            $ultima_fecha = $ultimo_cronjob->row(0)->fecha_newsletter;
                            $diff = abs(strtotime(mdate("%Y-%m-%d")) - strtotime($ultima_fecha));
                            $diff_en_dias = ($diff/(60*60*24));
                        }
                        if (sizeof($ultimo_cronjob)== 0 || $diff_en_dias > 6 ):

                            $tips = $this->tip_model->dar_tips_ultimos(3);
                            $noticias = $this->noticia_model->dar_noticias_ultimas(3);
                            $preguntas = $this->pregunta_model->dar_preguntas_ultimas(3);
                            $data['tip'] = $tips;
                            $data['noticia'] = $noticias;
                            $data['preguntas'] = $preguntas;

                            $this->load->view('newsletter/noticiasHTML_noEmail', $data);
                        endif;
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