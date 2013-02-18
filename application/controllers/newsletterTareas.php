<?php

require_once 'laspartes_controller.php';

error_reporting(E_ALL);
ini_set('display_errors', '1');

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
                $this->load->model('tip_model');
                $this->load->model('pregunta_model');


                $tips = $this->tip_model->dar_tips_ultimos(3);

                $preguntas = $this->pregunta_model->dar_preguntas_ultimas(3);

                $suscritos = $this->usuario_model->dar_usuarios_tareas();
//                $suscritos[] = $this->usuario_model->dar_usuario_segun_mail('cabarique.luis@gmail.com');
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
                            $data['tip'] = $tips;
                            $data['preguntas'] = $preguntas;
                            $data['fecha'] = strftime("%B %d de %Y");
                            $data['kilometraje_ciudad'] = $kilometraje_ciudad;
                            $data['nombre'] = $suscrito->nombres . " " . $suscrito->apellidos;
                            $data['kilometraje'] = $vehiculo->kilometraje;
                            $data['marca'] = $vehiculo->marca;
                            $data['linea'] = $vehiculo->linea;
                            $data['numero_placa'] = " ";
                            if (isset($vehiculo->numero_placa) && sizeof($vehiculo->numero_placa)> 4) {
                                $data['numero_placa'] = " con número de placa " . $vehiculo->numero_placa;
                            }else{
                                $data['numero_placa'] = " ";
                            }
                            $log = "correo newsletter tareas enviado a: " . $suscrito->nombres . " al correo: " . $suscrito->email .
                                    " al vehiculo: " . $vehiculo->numero_placa . "\n";
                            $log .= "Según nuestros cálculos, tu carro " .$data['marca']. " " .$data['linea']. " " .$data['numero_placa']. " debe tener ". $vehiculo->kilometraje. " kms.\n ";
                            $logOfertaTarea = "";
                            $tareas = $this->_dar_tareas_vehiculo($vehiculo, $kilometraje_ciudad, $id_usuario);
                            if (sizeof($tareas) >= 1) {
                                foreach ($tareas as $tarea) {
                                    if ( $tarea->realizado != true) {
                                        $ofertas[$tarea->id_servicio] = $this->usuario_model->dar_ofertas($tarea->id_tarea, $vehiculo->id_vehiculo);
                                    
                                        $logOfertaTarea .= "Tarea ID: " . $tarea->id_servicio . " tarea nombre: " . $tarea->nombre."\n";
                                        foreach ($ofertas[$tarea->id_servicio] as $oferta) {

                                            $logOfertaTarea .= "             Oferta ID: " . $oferta->id_oferta . " Oferta nombre: " . $oferta->titulo."\n";
                                        }
                                        $logOfertaTarea .= "\n";
                                       
                                    }                                    
                                    
                                }
                                $logOfertaTarea .= " --------------------------------------------------------------- \n";
                                $log .= $logOfertaTarea;
                                $data['tareas'] = $tareas;
                                $data['ofertas'] = $ofertas;

                                ob_start();
                                $this->load->view('newsletter/tareasHTML', $data);
                                $contenidoHTML = ob_get_contents();
                                ob_end_clean();
//                                ob_flush();
                                send_mail($destinatarios, "Boletín de tareas Laspartes.com - " . strftime("%B %d de %Y"), $contenidoHTML, "", "");
//                               echo $contenidoHTML;



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
    function _dar_tareas_vehiculo($vehiculo, $kilometraje_ciudad, $id_usuario) {
        $this->load->helper('date');
        $tareas = array();
        $tareas_asignadas = array();
        $kilometraje_mensual = $kilometraje_ciudad / 12;
        $kilometraje_actual = $vehiculo->kilometraje;
        $tareas = $this->usuario_model->dar_tareas_vehiculo($vehiculo->id_vehiculo, 1);
        $fecha_actual = mdate("%Y-%m-%d");
        foreach ($tareas as $tarea) {
            $tarea->realizado = false;
            if ($tarea->id_servicio == 9) {
                $fecha_SOAT = $this->usuario_model->dar_fecha_legales_SOAT($vehiculo->id_usuario_vehiculo);
                if (isset($fecha_SOAT) && $fecha_SOAT != "") {
                    
                    $diff_fecha_SOAT = abs(strtotime($fecha_actual) - strtotime($fecha_SOAT)) / (60 * 60 * 24);
                    if ($diff_fecha_SOAT < 60 && $diff_fecha_SOAT >= 0) {
                        $porcentaje = ($diff_fecha_SOAT * 100) / (60);
                        $tarea->barra_progreso = $porcentaje;
                        $tarea->dias_restantes = $diff_fecha_SOAT;
                        $tarea->mensaje_dias_restantes = "Faltan: ";
                        $tarea->mensaje_dias_restantes2 = " días para que lo hagas";
                        $tareas_asignadas[] = $tarea;
                    } else if ($diff_fecha_SOAT < 0 && $diff_fecha_SOAT > -60) {
                        $porcentaje = ($diff_fecha_SOAT * 100) / (60);
                        $tarea->barra_progreso = $porcentaje;
                        $tarea->dias_restantes = $diff_fecha_SOAT;
                        $tarea->mensaje_dias_restantes = "Hace: ";
                        $tarea->mensaje_dias_restantes2 = " días debiste hacerlo";
                        $tareas_asignadas[] = $tarea;
                    } else if ($diff_fecha_SOAT > 60) {
                        $tarea->realizado = true;
                        $tareas_asignadas[] = $tarea;
                    }
                }
            } else if ($tarea->id_servicio == 10) {
                $fecha_Tecnomecanica = $this->usuario_model->dar_fecha_legales_Tecnomecanica($vehiculo->id_usuario_vehiculo);
                if (isset($fecha_Tecnomecanica) && $fecha_Tecnomecanica != "") {
                    $tarea->realizado = false;
                    $diff_fecha_tecnomecanica = abs(strtotime($fecha_actual) - strtotime($fecha_Tecnomecanica)) / (60 * 60 * 24);

                    if ($diff_fecha_tecnomecanica < 60 && $diff_fecha_tecnomecanica >= 0) {
                        $porcentaje = ($diff_fecha_tecnomecanica * 100) / (60);
                        $tarea->barra_progreso = $porcentaje;
                        $tarea->dias_restantes = $diff_fecha_tecnomecanica;
                        $tarea->mensaje_dias_restantes = "Faltan: ";
                        $tarea->mensaje_dias_restantes2 = " días para que lo hagas";
                        $tareas_asignadas[] = $tarea;
                    } else if ($diff_fecha_tecnomecanica < 0 && $diff_fecha_tecnomecanica > -60) {
                        $porcentaje = ($diff_fecha_tecnomecanica * 100) / (60);
                        $tarea->barra_progreso = $porcentaje;
                        $tarea->dias_restantes = $diff_fecha_tecnomecanica;
                        $tarea->mensaje_dias_restantes = "Hace: ";
                        $tarea->mensaje_dias_restantes2 = " días debiste hacerlo";
                        $tareas_asignadas[] = $tarea;
                    } else if ($diff_fecha_tecnomecanica > 60) {
                        $tarea->due = strftime("%B %d de %Y", strtotime($fecha_Tecnomecanica));
                        $tarea->realizado = true;
                        $tareas_asignadas[] = $tarea;
                    }
                }
            } else {
                $realizado = $this->usuario_model->dar_tarea_realizada_vehiculo($vehiculo->id_usuario_vehiculo, $tarea->id_servicio);
                if (!is_bool($realizado)) {
                    $ultima_fecha = $realizado->ultima_fecha;
                    $diff = abs(strtotime($fecha_actual) - strtotime($ultima_fecha));
                    $diff_en_dias = ($diff / (60 * 60 * 24));
                    $years = floor($diff / (365 * 60 * 60 * 24));
                    $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                    $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
                    $barra_progreso = 0;
                    $periodicidad = $tarea->periodicidad;
                    $rango_inferior = $kilometraje_actual % $periodicidad;
                    if ($diff_en_dias <= 60) {
                        $tarea->realizado = true;
                    }
                    if ($rango_inferior == 0) {
                        $barra_progreso = "100";
                        $tarea->barra_progreso = $barra_progreso;
                        $tarea->dias_restantes = 0;
                        $tarea->mensaje_dias_restantes = "Faltan";
                        $tarea->mensaje_dias_restantes2 = " días para que lo hagas";
                        $tareas_asignadas[] = $tarea;
                    } else if (($kilometraje_mensual * 2) > $rango_inferior) {
                        $porcentaje = ($rango_inferior * 100) / (2 * $kilometraje_mensual);
                        $barra_progreso = $porcentaje;
                        $dias_restantes = round(($rango_inferior * 60) / ($kilometraje_mensual * 2));
                        $tarea->dias_restantes = $dias_restantes;
                        $tarea->mensaje_dias_restantes = "Hace: ";
                        $tarea->mensaje_dias_restantes2 = " días debiste hacerlo";
                        $tarea->barra_progreso = $barra_progreso;
                        $tareas_asignadas[] = $tarea;
                    } else if ($kilometraje_actual - ($periodicidad - $rango_inferior) > ($kilometraje_actual - ($kilometraje_mensual * 2))) {
                        $porcentaje = 100 - (($periodicidad - $rango_inferior) * 100) / (2 * $kilometraje_mensual);
                        $barra_progreso = $porcentaje;
                        $tarea->barra_progreso = $barra_progreso;
                        $dias_restantes = round((($periodicidad - $rango_inferior) * 60) / ($kilometraje_mensual * 2));
                        $tarea->dias_restantes = $dias_restantes;
                        $tarea->mensaje_dias_restantes = "Faltan: ";
                        $tarea->mensaje_dias_restantes2 = " días para que lo hagas";
                        $tareas_asignadas[] = $tarea;
                    }
                } else {
                    $barra_progreso = 0;
                    $periodicidad = $tarea->periodicidad;
                    $rango_inferior = $kilometraje_actual % $periodicidad;
                    if ($rango_inferior == 0) {
                        $barra_progreso = "100";
                        $tarea->barra_progreso = $barra_progreso;
                        $tarea->dias_restantes = 0;
                        $tarea->mensaje_dias_restantes = "Faltan: ";
                        $tarea->mensaje_dias_restantes2 = " días para que lo hagas";
                        $tareas_asignadas[] = $tarea;
                    } else if (($kilometraje_mensual * 2) > $rango_inferior) {
                        $porcentaje = ($rango_inferior * 100) / (2 * $kilometraje_mensual);
                        $barra_progreso = $porcentaje;
                        $dias_restantes = round(($rango_inferior * 60) / ($kilometraje_mensual * 2));
                        $tarea->dias_restantes = $dias_restantes;
                        $tarea->mensaje_dias_restantes = "Hace: ";
                        $tarea->mensaje_dias_restantes2 = " días debiste hacerlo";
                        $tarea->barra_progreso = $barra_progreso;
                        $tareas_asignadas[] = $tarea;
                    } else if ($kilometraje_actual - ($periodicidad - $rango_inferior) > ($kilometraje_actual - ($kilometraje_mensual * 2))) {
                        $porcentaje = 100 - (($periodicidad - $rango_inferior) * 100) / (2 * $kilometraje_mensual);
                        $barra_progreso = $porcentaje;
                        $tarea->barra_progreso = $barra_progreso;
                        $dias_restantes = round((($periodicidad - $rango_inferior) * 60) / ($kilometraje_mensual * 2));
                        $tarea->dias_restantes = $dias_restantes;
                        $tarea->mensaje_dias_restantes = "Faltan: ";
                        $tarea->mensaje_dias_restantes2 = " días para que lo hagas";
                        $tareas_asignadas[] = $tarea;
                    }
                }
            }
        }


        return $tareas_asignadas;
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