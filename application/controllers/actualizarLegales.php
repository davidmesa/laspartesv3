<?php

require_once 'laspartes_controller.php';

/**
 * Controlador que actualiza la información legal del vehículo
 * SOAT: Guarda la fecha de vigencia en la BD
 * Tecnicomecánica: Guarda la fecha de vigencia en la BD
 */
class ActualizarLegales extends Laspartes_Controller {

    /**
     * Constructor de la clase 
     */
    function __construct() {
        parent::__construct();
    }

    /**
     * Realiza la actualización de SOAT y Revisión Tecnomecánica de todos los usuarios
     */
    function index( ) {
        $hashValidation = $this->input->post('param');
        if(isset($hashValidation) && $this->validarHash($hashValidation)){
            $this->load->model('usuario_model');
            $this->load->helper('date');
            $ultimo_cronjob = $this->usuario_model->dar_ultimo_cronjob_tipo('legales');
            $diff_en_dias = 0;
            if (sizeof($ultimo_cronjob) == 1) {
                $ultima_fecha = $ultimo_cronjob->fecha;
                $diff = abs(strtotime(mdate("%Y-%m-%d")) - strtotime($ultima_fecha));
                $diff_en_dias = ($diff / (60 * 60 * 24));
            }
            if (sizeof($ultimo_cronjob) == 0 || $diff_en_dias > 0):
                echo "se esta realizando el cronjob de actualizar legales de todos los usuarios". '<br/>';
                $usuarios = array();
                $usuarios = $this->usuario_model->dar_usuarios();
                foreach ($usuarios as $usuario) {

                    $vehiculos_usuario = $this->usuario_model->dar_vehiculos_usuario($usuario->id_usuario);
                    foreach ($vehiculos_usuario as $vehiculo) {
                        $fechaVigenciaSOAT = "";
                        $fechaVigenciaTecnMec = "";
                        if (strlen($vehiculo->numero_placa) > 0 ) {
                            $search  = array(' ', '-', '/');
                            $numero_placa = str_replace($search, '', $vehiculo->numero_placa);
                            $ckfile = tempnam("resources/tmp", "CURLCOOKIE");
                            $ch = curl_init("http://www.runt.com.co/runt/ciudadanos/consultas/consulta_vehiculo_por_numero_placa.jsf");
                            curl_setopt($ch, CURLOPT_COOKIEJAR, $ckfile);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_HEADER, true);
                            $output = curl_exec($ch);
                            $ch = curl_init("http://www.runt.com.co/runt/ciudadanos/consultas/consulta_vehiculo_por_numero_placa.jsf");
                            curl_setopt($ch, CURLOPT_HEADER, false);
                            curl_setopt($ch, CURLOPT_COOKIEFILE, $ckfile);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            $fields = array(
                                'formConsultaVehiculoPorNumeroPlacaBean:numeroPlaca' => $numero_placa,
                                'formConsultaVehiculoPorNumeroPlacaBean:btnBuscar' => 'Buscar',
                                'formConsultaVehiculoPorNumeroPlacaBean' => 'formConsultaVehiculoPorNumeroPlacaBean',
                                'autoScroll' => '',
                                'javax.faces.ViewState' => 'j_id1'
                            );
                            $fields_string = '';
                            foreach ($fields as $key => $value) {
                                $fields_string .= $key . '=' . $value . '&';
                            }
                            rtrim($fields_string, '&');


                            curl_setopt($ch, CURLOPT_POST, count($fields));
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
                            curl_setopt($ch, CURLOPT_POST, true);

                            $options = array(
                                CURLOPT_REFERER => 'http://www.runt.com.co/runt/ciudadanos/consultas/consulta_vehiculo_por_numero_placa.jsf',
                                CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/536.5 (KHTML, like Gecko) Chrome/19.0.1084.56 Safari/536.5',
                                CURLOPT_ENCODING => 'gzip,deflate,sdch'
                            );

                            curl_setopt_array($ch, $options);

                            $output = curl_exec($ch);

                            $htmlRunt = $output;

                            $idVigenciaTecnMecanica = 'formConsultaVehiculoPorNumeroPlacaBean:panelFechaVig';
                            $posVigenciaTecnMecanica = strripos($htmlRunt, $idVigenciaTecnMecanica) + strlen($idVigenciaTecnMecanica);

                            $trimVigenciaTecnMecanica = substr($htmlRunt, $posVigenciaTecnMecanica);

                            $inicio = stripos($trimVigenciaTecnMecanica, '>') + 1;
                            $final = stripos($trimVigenciaTecnMecanica, '<');

                            $fechaVigenciaTecnMec = substr($trimVigenciaTecnMecanica, $inicio, $final - $inicio);

                            
                            if(isset($fechaVigenciaTecnMec) && strlen($fechaVigenciaTecnMec)>0 && !empty($fechaVigenciaTecnMec) && $fechaVigenciaTecnMec != 'No aplica' ){
                                list($first , $second, $third) = split('[/.-]', $fechaVigenciaTecnMec);
                                 if(strlen($third) >=3){
                                     $fechaVigenciaTecnMec = $third.'/'.$second.'/'.$first;
                                 }
                                $fechaVigenciaTecnMec = str_replace('/', '-', $fechaVigenciaTecnMec);
                                
                               
                            }
                            echo 'Fecha de vigencia rev. tecn. mec.: ' . $fechaVigenciaTecnMec . '<br/>';

                            $idVigenciaSOAT = 'formConsultaVehiculoPorNumeroPlacaBean:panelGridGSoatFecha';
                            $posVigenciaSOAT = strripos($htmlRunt, $idVigenciaSOAT) + strlen($idVigenciaSOAT);

                            $trimVigenciaSOAT = substr($htmlRunt, $posVigenciaSOAT);

                            $idVigenciaSOAT = 'col2';
                            $posVigenciaSOAT = strpos($trimVigenciaSOAT, $idVigenciaSOAT) + strlen($idVigenciaSOAT);

                            $trimVigenciaSOAT = substr($trimVigenciaSOAT, $posVigenciaSOAT);

                            $inicio = stripos($trimVigenciaSOAT, '>') + 1;
                            $final = stripos($trimVigenciaSOAT, '<');

                            $fechaVigenciaSOAT = substr($trimVigenciaSOAT, $inicio, $final - $inicio);

                           
                           if(isset($fechaVigenciaSOAT)&& strlen($fechaVigenciaSOAT)>0 && !empty($fechaVigenciaSOAT) && $fechaVigenciaSOAT != 'No aplica'){
                                list($first , $second, $third) = split('[/.-]', $fechaVigenciaSOAT);
                                 if(strlen($third) >=3){
                                     $fechaVigenciaSOAT = $third.'/'.$second.'/'.$first;
                                 }
                                $fechaVigenciaSOAT = str_replace('/', '-', $fechaVigenciaSOAT);
                                
                               
                            }
                            

                            echo 'Fecha de vigencia SOAT: ' . $fechaVigenciaSOAT . '<br/>';

//                            $idEmpresaSOAT = 'formConsultaVehiculoPorNumeroPlacaBean:panelGridGSoatEntidad';
//                            $posEmpresaSOAT = strripos($htmlRunt, $idEmpresaSOAT) + strlen($idEmpresaSOAT);
//
//                            $trimEmpresaSOAT = substr($htmlRunt, $posEmpresaSOAT);
//
//                            $idEmpresaSOAT = 'col2';
//                            $posEmpresaSOAT = strpos($trimEmpresaSOAT, $idEmpresaSOAT) + strlen($idEmpresaSOAT);
//
//                            $trimEmpresaSOAT = substr($trimEmpresaSOAT, $posEmpresaSOAT);
//
//                            $inicio = stripos($trimEmpresaSOAT, '>') + 1;
//                            $final = stripos($trimEmpresaSOAT, '<');
//
//                            $fechaEmpresaSOAT = substr($trimEmpresaSOAT, $inicio, $final - $inicio);
//                            $fechaEmpresaSOAT = str_replace('/', '-', $fechaEmpresaSOAT);
//
//                            echo 'La empresa de seguros es: ' . $fechaEmpresaSOAT . '<br/>';



                            //se escribe el log de actualizaciones
                            $this->usuario_model->actualizar_tarea_realizada_vehiculo($vehiculo->id_usuario_vehiculo, 9, $fechaVigenciaSOAT);
                            $this->usuario_model->actualizar_tarea_realizada_vehiculo($vehiculo->id_usuario_vehiculo, 10, $fechaVigenciaTecnMec);
                            $stringData = "ID_usuario: " . $usuario->id_usuario . " Vehiculo:" . $vehiculo->id_usuario_vehiculo . " Placa:" . $numero_placa ." Vigencia SOAT:" . $fechaVigenciaSOAT . " Vigencia Tecnomecanica:" . $fechaVigenciaTecnMec . "\n";
                            $this->guardarLog("legales", $stringData);
                        }
                    }
                }
                $this->usuario_model->agregar_cronjob('legales');
            endif;
        }
    }

    function validarHash($hash = '') {
        $fecha1 = date('Y-F-d');
        $fecha2 = date('Y-m-d');
        $hash1 = md5($fecha1);
        $hash2 = md5($fecha2);
        $param = $hash1 . "|" . $hash2;

        return strcmp($hash, $param) == 0;
    }

}
