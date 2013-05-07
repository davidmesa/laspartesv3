<?php

require_once('/hsphere/local/home/laspartes/laspartes.com/application/controllers/laspartes_controller.php');

/**
 * Clase que envía el newsletter de vencimiento de técnico mecánica
 */
class NewsletterTecnicoMecanica extends Laspartes_Controller {

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
            $ultimo_cronjob = $this->usuario_model->dar_ultimo_cronjob_tipo('tecnomecanica');
            $diff_en_dias = 0;
            if (sizeof($ultimo_cronjob) == 1) {
                $ultima_fecha = $ultimo_cronjob->fecha;
                $diff = abs(strtotime(mdate("%Y-%m-%d")) - strtotime($ultima_fecha));
                $diff_en_dias = ($diff / (60 * 60 * 24));
            }
            if (sizeof($ultimo_cronjob) == 0 || $diff_en_dias > 6):
                $data = $dataP;
                $this->load->model('usuario_model');

                $this->load->helper('date');
                $this->load->helper('mail');

                setlocale(LC_ALL, 'es_ES');
                define("CHARSET", "iso-8859-1");

                $data['fecha'] = strftime("%B %d de %Y");
                $suscritos = $this->usuario_model->dar_usuarios_tipo(30);

                foreach ($suscritos as $suscrito) {
                    $carros = $this->usuario_model->dar_vehiculos_usuario($suscrito->id_usuario);
                    foreach ($carros as $carro) {
                        if ($carro->numero_placa != '') {
                            $data['carro'] = $carro;
                            $data['tarea'] = $this->_dar_dias_tecnicomecanica($carro);
                            $tarea = $data['tarea'];
                            if ($data['tarea'] != false):
                                $destinatarios = array();
                                $destinatario = new stdClass();
                                $destinatario->email = $suscrito->email;
                                $destinatario->nombres = $suscrito->nombres . " " . $suscrito->apellidos;
                                $destinatarios[] = $destinatario;
                                $data['usuario'] = $suscrito;
                                ob_start();
                                $this->load->view('newsletter/tecnico_mecanica', $data);
                                $contenidoHTML = ob_get_contents();
                                ob_end_clean();
//                        echo $contenidoHTML;
                                send_mail($destinatarios, $tarea->mensaje_dias_restantes . ' ' . $tarea->dias_restantes . ' ' . $tarea->mensaje_dias_restantes2, $contenidoHTML, "", "");

                                echo "Correo enviado a: " . $suscrito->nombres . " " . $suscrito->apellidos . " al correo: <strong>" . $suscrito->email . "</strong><br/>";
                            endif;
                        }
                    }
                }
                $this->usuario_model->agregar_cronjob('tecnomecanica');
            endif;
        }
    }

    /**
     * función que retorna los días que hacen falta para el vencimiento de
     * la técnico mecánica
     * @param vehiculo $vehiculo
     * @param int $kilometraje_mensual
     * @return array tareas a realizar 
     */
    function _dar_dias_tecnicomecanica($vehiculo) {
        $this->load->helper('date');
        $tareas = array();
        $tareas = $this->usuario_model->dar_tareas_vehiculo($vehiculo->id_vehiculo);
        $fecha_actual = mdate("%Y-%m-%d");
        foreach ($tareas as $tarea) {
            if ($tarea->id_servicio == 10) {
                $fecha_Tecnomecanica = $this->usuario_model->dar_legales_Tecnomecanica($vehiculo->id_usuario_vehiculo)->ultima_fecha;
                if (isset($fecha_Tecnomecanica) && $fecha_Tecnomecanica != '' && $fecha_Tecnomecanica != null && $fecha_Tecnomecanica != '0000-00-00' && strrpos($fecha_Tecnomecanica, '0000') == false) {
                    $tarea->ultima_fecha = $fecha_Tecnomecanica;
                    $diff_fecha_tecnomecanica = round((strtotime($fecha_actual) - strtotime($fecha_Tecnomecanica)) / (60 * 60 * 24));
//                    echo $vehiculo->id_usuario_vehiculo.' '.strtotime($fecha_actual).' '.strtotime($fecha_Tecnomecanica).' '.$diff_fecha_tecnomecanica. '<br/>';
                    if ($diff_fecha_tecnomecanica == -30 || $diff_fecha_tecnomecanica == -7) {
                        $tarea->dias_restantes = abs($diff_fecha_tecnomecanica);
                        $tarea->mensaje_dias_restantes = "¡Te quedan: ";
                        $tarea->mensaje_dias_restantes2 = " días para que renueves tu revisión Técnico-mecánica! ";
                        $tareas_asignadas = $tarea;
                    } else if ($diff_fecha_tecnomecanica == 15) {
                        $tarea->mensaje_dias_restantes = "¡Debes renovar tu revisión Técnico-mecánica!";
                        $tareas_asignadas = $tarea;
                    }
                    return $tareas_asignadas;
                }else
                    return false;
            }
        }
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