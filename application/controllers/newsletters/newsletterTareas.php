<?php
require_once('/hsphere/local/home/laspartes/laspartes.com/application/controllers/laspartes_controller.php');

//error_reporting(E_ALL);
//ini_set('display_errors', '1');

/**
 * Clase que maneja la página principal
 */
class NewsletterTareas extends Laspartes_Controller {

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
        if (isset($hashValidation) && $this->validarHash($hashValidation)) {
            $this->load->model('usuario_model');
            $this->load->helper('date');
            $this->load->helper('mail');
            setlocale(LC_ALL, 'es_ES');
            $ultimo_cronjob = $this->usuario_model->dar_ultimo_cronjob_tipo('tareamto');
            $diff_en_dias = 0;
            if (sizeof($ultimo_cronjob) == 1) {
                $ultima_fecha = $ultimo_cronjob->fecha;
                $diff = abs(strtotime(mdate("%Y-%m-%d")) - strtotime($ultima_fecha));
                $diff_en_dias = ($diff / (60 * 60 * 24));
            }
            if (sizeof($ultimo_cronjob) == 0 || $diff_en_dias > 6):
                $data = $dataP;

                $suscritos = $this->usuario_model->dar_usuarios_tareas();
                foreach ($suscritos as $suscrito) {
                    $data = array();
                    $destinatarios = array();
                    $destinatario = new stdClass();
                    $destinatario->email = $suscrito->email;
                    $destinatario->nombres = $suscrito->nombres . " " . $suscrito->apellidos;
                    $destinatarios[] = $destinatario;


                    $usuario = $this->usuario_model->dar_usuario_segun_mail($suscrito->email);
                    $id_usuario = $usuario->id_usuario;
                    $lugar = $usuario->lugar;
                    $kilometraje_ciudad = $this->usuario_model->dar_kilometraje_ciudad($lugar);

                    $vehiculos = $this->usuario_model->dar_vehiculos_usuario($id_usuario);
                    if (sizeof($vehiculos) >= 1):
                        foreach ($vehiculos as $vehiculo) {
                            $log = "";
                            $logOfertaTarea = "";
                            $data = array();
                            $data['fecha'] = strftime("%B %d de %Y");
                            $data['kilometraje_ciudad'] = $kilometraje_ciudad;
                            $data['nombre'] = $suscrito->nombres . " " . $suscrito->apellidos;
                            $data['kilometraje'] = $vehiculo->kilometraje;
                            $data['marca'] = $vehiculo->marca;
                            $data['linea'] = $vehiculo->linea;
                            $data['numero_placa'] = " ";
                            if (isset($vehiculo->numero_placa) && strlen($vehiculo->numero_placa)> 4) {
                                $data['numero_placa'] = " con número de placa <strong>" . $vehiculo->numero_placa.'</strong>';
                            }else{
                                $data['numero_placa'] = " ";
                            }
                            $log = "correo newsletter tareas enviado a: " . $suscrito->nombres . " al correo: " . $suscrito->email .
                                    " al vehiculo: " . $vehiculo->numero_placa . "\n";
                            $log .= "Según nuestros cálculos, tu carro " .$data['marca']. " " .$data['linea']. " " .$data['numero_placa']. " debe tener ". $vehiculo->kilometraje. " kms.\n ";
                            $logOfertaTarea = "";
                            $tareas = $this->_dar_tareas_vehiculo($vehiculo, $kilometraje_ciudad);
                            if (sizeof($tareas) >= 1) {
                                foreach ($tareas as $tarea) {
                                    if ( $tarea->realizado != true) {
                                        $data['tarea'] = $tarea;
                                        $ofertas = $this->usuario_model->dar_oferta_por_tarea($tarea->id_tarea, $vehiculo->id_vehiculo, 2);
                                        $data['ofertas'] = $ofertas;
                                        $logOfertaTarea .= "Tarea ID: " . $tarea->id_servicio . " tarea nombre: " . $tarea->nombre."\n";
                                        foreach ($ofertas as $oferta) {

                                            $logOfertaTarea .= "             Oferta ID: " . $oferta->id_oferta . " Oferta nombre: " . $oferta->titulo."\n";
                                        }
                                        $logOfertaTarea .= "\n";
                                       ob_start();
                                        $this->load->view('newsletter/tareasHTML', $data);
                                        $contenidoHTML = ob_get_contents();
                                        ob_end_clean();
//                                       echo $contenidoHTML;
                                       $this->usuario_model->guardar_html_correo_usuario($id_usuario, $suscrito->email, $contenidoHTML, 'Laspartes.com - vencimiento de '.$data['tarea']->nombre);
                                    }                                    
                                    
                                }
                                $logOfertaTarea .= " --------------------------------------------------------------- \n";
                                $log .= $logOfertaTarea;

                                



                                $this->guardarLog("tareas", $log);
                            }
                        }
                    endif;
                }
                $this->usuario_model->agregar_cronjob('tareamto');
            endif;
        }
    }
    


    /**
     * función que retorna las tareas a realizar para un vehiculo dado
     * @param vehiculo $vehiculo
     * @param int $kilometraje_mensual
     * @return array tareas a realizar 
     */
    function _dar_tareas_vehiculo($vehiculo, $kilometraje_ciudad) {
        $this->load->helper('date');
        $tareas = array();
        $tareas_asignadas = array();
        $kilometraje_mensual = $kilometraje_ciudad / 12;
        $kilometraje_diario = $kilometraje_ciudad / 365;
        $kilometraje_actual = $vehiculo->kilometraje;
        if ($kilometraje_actual > 3000) {
            $tareas = $this->usuario_model->dar_tareas_vehiculo($vehiculo->id_vehiculo, $vehiculo->modelo);
            $fecha_actual = mdate("%Y-%m-%d");
            foreach ($tareas as $tarea) {
                $tarea->realizado = false;
                if ($tarea->id_servicio ==1){
                    $realizados = $this->usuario_model->dar_tarea_realizada_vehiculo($vehiculo->id_usuario_vehiculo, $tarea->id_servicio);
                    if (!is_bool($realizados)) {
                        $validarFecha = true;
                        foreach ($realizados as $realizado):
                            $barra_progreso = 0;
                            $periodicidad = $tarea->periodicidad;
                            $rango_inferior = $kilometraje_actual % $periodicidad;
                            $ultima_fecha = $realizado->ultima_fecha;
                            $diff = abs(strtotime($fecha_actual) - strtotime($ultima_fecha));
                            $diff_en_dias = ($diff / (60 * 60 * 24));
                                
                            if ($diff_en_dias > 60  && $validarFecha){
                                if (($kilometraje_mensual * 2) > $rango_inferior || (($periodicidad-$rango_inferior) <= $kilometraje_diario && $rango_inferior >=0)) {
                                    $porcentaje = ($rango_inferior * 100) / (2 * $kilometraje_mensual);
                                    $barra_progreso = $porcentaje;
                                    $dias_restantes = round(($rango_inferior * 60) / ($kilometraje_mensual * 2));
                                     if($dias_restantes == 30 || $dias_restantes == 0){
                                        $tarea->mensaje_dias_restantes = "DEBES HACERLO";
                                        $tarea->dias_restantes = $dias_restantes;
                                        $tarea->barra_progreso = $barra_progreso;
                                        $tareas_asignadas[] = $tarea;
                                    }
                                }
                            }
                            $validarFecha = false;
                        endforeach;
                    } else {
                        $barra_progreso = 0;
                        $periodicidad = $tarea->periodicidad;
                        $rango_inferior = $kilometraje_actual % $periodicidad; 
                        if (($kilometraje_mensual * 2) >= $rango_inferior || (($periodicidad-$rango_inferior) <= $kilometraje_diario && $rango_inferior >=0)) {
                            $porcentaje = ($rango_inferior * 100) / (2 * $kilometraje_mensual);
                            $barra_progreso = $porcentaje;
                            $dias_restantes = round(($rango_inferior * 60) / ($kilometraje_mensual * 2));
                            if($dias_restantes == 30 || $dias_restantes == 0){
                                $tarea->mensaje_dias_restantes = "DEBES HACERLO";
                                $tarea->dias_restantes = $dias_restantes;
                                $tarea->barra_progreso = $barra_progreso;
                                $tareas_asignadas[] = $tarea;
                            }
                            
                        }
                    }
                }
            }
            return $tareas_asignadas;
        }
    }
    
    /**
     * Función que envía el primer correo de tareas que tenga en cola un usuario
     */
    function enviar_correos_tareas(){
        $this->load->model('usuario_model');
        $this->load->helper('mail');
        $usuarios = $this->usuario_model->dar_cola_usuarios();
        foreach ($usuarios as $usuario) {
            $contenido = $this->usuario_model->dar_cola_correos_enviar($usuario->id_usuario);
            $destinatarios = array();
            $destinatario = new stdClass();
            $destinatario->email = $usuario->email;
            $destinatarios[] = $destinatario;
            send_mail($destinatarios, $contenido->titulo, $contenido->contenido, "", "");
            echo "Correo enviado al correo: <strong>" . $usuario->email . "</strong><br/>";
            $this->usuario_model->eliminar_correo_cola($contenido->id_cola_correos);
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