<?php

require_once('/hsphere/local/home/laspartes/laspartes.com/application/controllers/laspartes_controller.php');

/**
 * Clase que envía el newsletter de recordatorio de SOAT
 */
class NewsletterCalificaExperiencia extends Laspartes_Controller {

    /**
     * Constructor de la clase
     */
    function __construct() {
        parent::__construct();
    }

    /**
     * Muestra la página principal
     */
    function index($dataP = array()) {
        $hashValidation = $this->input->post('param');
        if (isset($hashValidation) && $this->validarHash($hashValidation)) {
            $this->load->model('usuario_model');
            $this->load->helper('date');
            $this->load->helper('mail');
            setlocale(LC_ALL, 'es_ES');
            $ultimo_cronjob = $this->usuario_model->dar_ultimo_cronjob_tipo('calificaExperiencia');
            $diff_en_dias = 0;
            if (sizeof($ultimo_cronjob) == 1) {
                $ultima_fecha = $ultimo_cronjob->fecha;
                $diff = abs(strtotime(mdate("%Y-%m-%d")) - strtotime($ultima_fecha));
                $diff_en_dias = ($diff / (60 * 60 * 24));
            }
            if (sizeof($ultimo_cronjob) == 0 || $diff_en_dias > 0):
                $data = $dataP;
                $this->load->model('usuario_model');

                $this->load->helper('date');
                $this->load->helper('mail');

                setlocale(LC_ALL, 'es_ES');
                define("CHARSET", "iso-8859-1");

                $data['fecha'] = strftime("%B %d de %Y");
                $suscritos = $this->usuario_model->dar_usuarios_califica_experiencia();
                foreach ($suscritos as $suscrito) {
                    $destinatarios = array();
                    $destinatario = new stdClass();
                    $destinatario->email = $suscrito->email;
                    $destinatario->nombres = $suscrito->nombres . " " . $suscrito->apellidos;
                    $destinatarios[] = $destinatario;
                    $data['usuario'] = $suscrito;
                    $llave = $this->usuario_model->generar_codConfirmacion_Unico();
                    $this->usuario_model->guardar_codConfirmacion_Unico($llave, $suscrito->id_carrito_compra, $suscrito->id_establecimiento);
                    ob_start();
                    $data['url'] = base_url() . 'usuario/califica_tu_experiencia/' . $llave . '?utm_source=email&utm_medium=calificar&utm_campaign=calificar%2Bexperiencia';
                    $this->load->view('newsletter/califica_experiencia_view', $data);
                    $contenidoHTML = ob_get_contents();
                    ob_end_clean();
//                    echo $contenidoHTML;
                send_mail($destinatarios, 'Califica tu experiencia en el taller '.$suscrito->taller, $contenidoHTML, "", "");

                    echo "Correo enviado a: " . $suscrito->nombres . " " . $suscrito->apellidos . " al correo: <strong>" . $suscrito->email . "</strong><br/>";
                }
                $this->usuario_model->agregar_cronjob('calificaExperiencia');
            endif;
        }
    }
    
    /**
     * enviar los correos de calificar experiencia con fecha anterior a el 8 de febrero de 2013
     */
    function enviar_emails_calificar(){
         
//            $this->load->model('usuario_model');
//            $this->load->helper('date');
//            $this->load->helper('mail');
//            setlocale(LC_ALL, 'es_ES');
//                $this->load->model('usuario_model');
//
//                $this->load->helper('date');
//                $this->load->helper('mail');
//
//                setlocale(LC_ALL, 'es_ES');
//                define("CHARSET", "iso-8859-1");
//
//                $data['fecha'] = strftime("%B %d de %Y");
//                $suscritos = $this->usuario_model->dar_usuarios_califica_experiencia_temp();
//                foreach ($suscritos as $suscrito) {
//                    $destinatarios = array();
//                    $destinatario = new stdClass();
//                    $destinatario->email = $suscrito->email;
//                    $destinatario->nombres = $suscrito->nombres . " " . $suscrito->apellidos;
//                    $destinatarios[] = $destinatario;
//                    $data['usuario'] = $suscrito;
//                    $llave = $this->usuario_model->generar_codConfirmacion_Unico();
//                    $this->usuario_model->guardar_codConfirmacion_Unico($llave, $suscrito->id_carrito_compra, $suscrito->id_establecimiento);
//                    ob_start();
//                    $data['url'] = base_url() . 'usuario/califica_tu_experiencia/' . $llave . '?utm_source=email&utm_medium=calificar&utm_campaign=calificar%2Bexperiencia';
//                    $this->load->view('newsletter/califica_experiencia_view', $data);
//                    $contenidoHTML = ob_get_contents();
//                    ob_end_clean();
////                    echo $contenidoHTML; 
//                send_mail($destinatarios, 'Califica tu experiencia en el taller '.$suscrito->taller, $contenidoHTML, "", "");
//
//                    echo "Correo enviado a: " . $suscrito->nombres . " " . $suscrito->apellidos . " al correo: <strong>" . $suscrito->email . "</strong><br/>";
//                }
    }

    /**
     * Valida que el hash que entra como parámetro se haya generado a partir
     * de la fecha en dos formatos. Se utiliza para verificar que este controlador
     * fue llamado desde el script ubicado en la carpeta "tasks"
     * @param type $hash
     * @return type 
     */
    function validarHash($hash = '') {
        $fecha1 = date('Y-F-d');
        $fecha2 = date('Y-m-d');
        $hash1 = md5($fecha1);
        $hash2 = md5($fecha2);
        $param = $hash1 . "|" . $hash2;

        return strcmp($hash, $param) == 0;
    }

}