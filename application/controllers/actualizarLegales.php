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
                // echo "se esta realizando el cronjob de actualizar legales de todos los usuarios". '<br/>';
                $usuarios = array();
                $usuarios = $this->usuario_model->dar_usuarios();
                foreach ($usuarios as $usuario) {

                    $vehiculos_usuario = $this->usuario_model->dar_vehiculos_usuario($usuario->id_usuario);
                    foreach ($vehiculos_usuario as $vehiculo) {
                        $fechaVigenciaSOAT = "";
                        $fechaVigenciaTecnMec = "";
                        if (!empty($vehiculo->numero_placa) && strlen($vehiculo->numero_placa) >=6 && !empty($vehiculo->documento)) {
                            $search  = array(' ', '-', '/');
                            $numero_placa = str_replace($search, '', $vehiculo->numero_placa);
                            $tipo_documento = $vehiculo->tipo_documento;
                            $documento = $vehiculo->documento;
                            $ckfile = tempnam("resources/tmp", "CURLCOOKIE");
                            $ch = curl_init("http://www.runt.com.co/runt/ciudadanos/consultas/consulta_vehiculo_por_placa_propietario.jsf");
                            curl_setopt($ch, CURLOPT_COOKIEJAR, $ckfile);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_HEADER, true);
                            $output = curl_exec($ch); 
                            $ch = curl_init("http://www.runt.com.co/runt/ciudadanos/consultas/consulta_vehiculo_por_placa_propietario.jsf");
                            curl_setopt($ch, CURLOPT_HEADER, false);
                            curl_setopt($ch, CURLOPT_COOKIEFILE, $ckfile);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            $fields = array(
                                'ConsultaVehiculoPorPlacaPropietarioBeanForm:personaTipoidentIdtipdocSearch' => $tipo_documento,
                                'ConsultaVehiculoPorPlacaPropietarioBeanForm:personaNrodocumeSearch' => $documento,
                                'ConsultaVehiculoPorPlacaPropietarioBeanForm:personaNroPlacaSearch' => $numero_placa,
                                'ConsultaVehiculoPorPlacaPropietarioBeanForm:procedenciaVehiculo' => 'NACIONAL', 
                                'ConsultaVehiculoPorPlacaPropietarioBeanForm:btnconsultarCiudadano' => 'Search',
                                'ConsultaVehiculoPorPlacaPropietarioBeanForm' => 'ConsultaVehiculoPorPlacaPropietarioBeanForm',
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
                                CURLOPT_REFERER => 'http://www.runt.com.co/runt/ciudadanos/consultas/consulta_vehiculo_por_placa_propietario.jsf',
                                CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/536.5 (KHTML, like Gecko) Chrome/19.0.1084.56 Safari/536.5',
                                CURLOPT_ENCODING => 'gzip,deflate,sdch'
                            );

                            curl_setopt_array($ch, $options);

                            $output = curl_exec($ch); 
                            $htmlRunt = $output;

                            echo "<br/><br/>CONSULTANDO ID_usuario: " . $usuario->id_usuario . " nombres: " .$usuario->nombres. " " .$usuario->apellidos ." documento: " .$tipo_documento ." ". $documento . " Vehiculo: " . $vehiculo->id_usuario_vehiculo . " Placa:" . $numero_placa ."\n<br/>";
                            $stringData = "\n\nCONSULTANDO ID_usuario: " . $usuario->id_usuario . " nombres: " .$usuario->nombres. " " .$usuario->apellidos ." documento: " .$tipo_documento ." ". $documento . " Vehiculo: " . $vehiculo->id_usuario_vehiculo . " Placa:" . $numero_placa ."\n";

                            if(strripos($htmlRunt, 'ConsultaVehiculoPorPlacaPropietarioBeanForm:pagedTableSoats:0:rowFechaVencimiento') != false 
                                && strripos($htmlRunt, 'Marca:') != false && strripos($htmlRunt, 'Nro. de motor:') != false
                                && strripos($htmlRunt, 'no ha sido registrado en el sistema RUNT') == false){

                                $dias = $this->dar_dias_SOAT_tecnicomecanica($vehiculo);
                                if($dias['tecnomecanica'] == false || $dias['tecnomecanica'] > -30){

                                    $idVigenciaTecnMecanica = 'ConsultaVehiculoPorPlacaPropietarioBeanForm:pagedTableRtm:0:rowFechaViegencia';
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
                                    $stringData .= "Fecha de vigencia rev. tecn. mec.: " . $fechaVigenciaTecnMec . "\n";
                                    $this->usuario_model->actualizar_tarea_realizada_vehiculo($vehiculo->id_usuario_vehiculo, 10, $fechaVigenciaTecnMec);
                                    
                                    $extra_data['revision'] = $fechaVigenciaTecnMec;
                                    $this->usuario_model->actualizar_vehiculo_usuario($vehiculo->id_usuario_vehiculo, '', '', '', '', '', '', $extra_data);
                                }

                                if($dias['soat'] == false || $dias['soat'] > -30){

                                    $idVigenciaSOAT = 'ConsultaVehiculoPorPlacaPropietarioBeanForm:pagedTableSoats:0:rowFechaVencimiento';
                                    $posVigenciaSOAT = strripos($htmlRunt, $idVigenciaSOAT) + strlen($idVigenciaSOAT);
                                    $trimVigenciaSOAT = substr($htmlRunt, $posVigenciaSOAT);

                                    
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
                                    $stringData .= "Fecha de vigencia SOAT: " . $fechaVigenciaSOAT . "\n";
                                    $this->usuario_model->actualizar_tarea_realizada_vehiculo($vehiculo->id_usuario_vehiculo, 9, $fechaVigenciaSOAT);


                                    $extra_data['soat'] = $fechaVigenciaSOAT;
                                    $this->usuario_model->actualizar_vehiculo_usuario($vehiculo->id_usuario_vehiculo, '', '', '', '', '', '', $extra_data);
                                }

                                //datos extras
                                
                                //nro licencia de transito
                                if(empty($vehiculo->licencia_transito) ||empty($vehiculo->clase_vehiculo) || empty($vehiculo->marca_RUNT) 
                                    || empty($vehiculo->modelo_RUNT) || empty($vehiculo->color)
                                    || empty($vehiculo->nro_motor) || empty($vehiculo->nro_chasis)
                                    || empty($vehiculo->cilindraje) || empty($vehiculo->linea_RUNT) ):
                                    $idlicenciaTransito = 'Nro. de licencia de tr&aacute;nsito'; 
                                    $poslicenciaTransito = strripos($htmlRunt, $idlicenciaTransito) + strlen($idlicenciaTransito);
                                    $trimlicenciaTransito = substr($htmlRunt, $poslicenciaTransito); //echo '<br/> TRIM: '.$trimlicenciaTransito.'<br/>';

                                    $inicio = stripos($trimlicenciaTransito, '<td>' )+ strlen('<td>') ;
                                    $final =  stripos(substr($trimlicenciaTransito, $inicio), '</td>');

                                    $licenciaTransito = substr($trimlicenciaTransito, $inicio, $final);
                                    $extra_data['licencia_transito'] = $licenciaTransito;

                                    echo 'Nro. licencia de transito: ' . $licenciaTransito . '<br/>';
                                    $stringData .= "Nro. licencia de transito: " . $licenciaTransito . "\n";

                                //estado del vehiculo
                                    $idestadoVehiculo = 'Estado del veh&iacute;culo:'; 
                                    $posestadoVehiculo = strripos($trimlicenciaTransito, $idestadoVehiculo) + strlen($idestadoVehiculo);
                                    $trimEstadoVehiculo = substr($trimlicenciaTransito, $posestadoVehiculo); //echo '<br/> TRIM: '.$trimlicenciaTransito.'<br/>';

                                    $inicio = stripos($trimEstadoVehiculo, '<td class="col_sinbordeder">' )+ strlen('<td class="col_sinbordeder">') ;
                                    $final =  stripos(substr($trimEstadoVehiculo, $inicio), '</td>');

                                    $estadoVehiculo = substr($trimEstadoVehiculo, $inicio, $final);
                                    $extra_data['estado_vehiculo'] = $estadoVehiculo;

                                    echo 'Estado del veh&iacute;culo: ' . htmlentities($estadoVehiculo) . '<br/>';
                                    $stringData .= "Estado del veh&iacute;culo: " . ($estadoVehiculo) . "\n";

                                //Tipo de servicio
                                    $idTipoServicio = 'Tipo de servicio:'; 
                                    $posTipoServicio = strripos($trimlicenciaTransito, $idTipoServicio) + strlen($idTipoServicio);
                                    $trimTipoServicio = substr($trimlicenciaTransito, $posTipoServicio); //echo '<br/> TRIM: '.$trimlicenciaTransito.'<br/>';

                                    $inicio = stripos($trimTipoServicio, '<td class="col_conbordeder">' )+ strlen('<td class="col_conbordeder">') ;
                                    $final =  stripos(substr($trimTipoServicio, $inicio), '</td>');

                                    $tipoServicio = substr($trimTipoServicio, $inicio, $final);
                                    $extra_data['tipo_servicio'] = $tipoServicio;

                                    echo 'Tipo de veh&iacute;culo: ' . htmlentities($tipoServicio) . '<br/>';
                                    $stringData .= "Tipo de veh&iacute;culo: " . ($tipoServicio) . "\n";

                                //Clase de vehículo
                                    $idClaseVehiculo = 'Clase de veh&iacute;culo:'; 
                                    $posClaseVehiculo = strripos($trimTipoServicio, $idClaseVehiculo) + strlen($idClaseVehiculo);
                                    $trimClaseVehiculo = substr($trimTipoServicio, $posClaseVehiculo); //echo '<br/> TRIM: '.$trimlicenciaTransito.'<br/>';

                                    $inicio = stripos($trimClaseVehiculo, '<td class="col_sinbordeder">' )+ strlen('<td class="col_sinbordeder">') ;
                                    $final =  stripos(substr($trimClaseVehiculo, $inicio), '</td>');

                                    $ClaseVehiculo = substr($trimClaseVehiculo, $inicio, $final);
                                    $extra_data['clase_vehiculo'] = $ClaseVehiculo;

                                    echo 'Clase de veh&iacute;culo: ' . htmlentities($ClaseVehiculo) . '<br/>';
                                    $stringData .= "Clase de veh&iacute;culo: " . ($ClaseVehiculo) . "\n";

                                //Marca
                                    $idMarca = 'Marca:'; 
                                    $posMarca = strripos($trimClaseVehiculo, $idMarca) + strlen($idMarca);
                                    $trimMarca = substr($trimClaseVehiculo, $posMarca); //echo '<br/> TRIM: '.$trimlicenciaTransito.'<br/>';

                                    $inicio = stripos($trimMarca, '<td class="col_conbordeder">' )+ strlen('<td class="col_conbordeder">') ;
                                    $final =  stripos(substr($trimMarca, $inicio), '</td>');

                                    $Marca = substr($trimMarca, $inicio, $final);
                                    $extra_data['marca_RUNT'] = $Marca;

                                    echo 'Marca: ' . htmlentities($Marca) . '<br/>';
                                    $stringData .= "Marca: " . ($Marca) . "\n";

                                //Línea
                                    $idLinea = 'L&iacute;nea:'; 
                                    $posLinea = strripos($trimMarca, $idLinea) + strlen($idLinea);
                                    $trimLinea = substr($trimMarca, $posLinea); //echo '<br/> TRIM: '.$trimlicenciaTransito.'<br/>';

                                    $inicio = stripos($trimLinea, '<td class="col_sinbordeder">' )+ strlen('<td class="col_sinbordeder">') ;
                                    $final =  stripos(substr($trimLinea, $inicio), '</td>');

                                    $Linea = substr($trimLinea, $inicio, $final);
                                    $extra_data['linea_RUNT'] = $Linea;

                                    echo 'Linea: ' . htmlentities($Linea) . '<br/>';
                                    $stringData .= "Linea: " . ($Linea) . "\n";

                                //Modelo
                                    $idModelo = 'Modelo:'; 
                                    $posModelo = strripos($trimLinea, $idModelo) + strlen($idModelo);
                                    $trimModelo = substr($trimLinea, $posModelo); //echo '<br/> TRIM: '.$trimlicenciaTransito.'<br/>';

                                    $inicio = stripos($trimModelo, '<td class="col_conbordeder">' )+ strlen('<td class="col_conbordeder">') ;
                                    $final =  stripos(substr($trimModelo, $inicio), '</td>');

                                    $Modelo = substr($trimModelo, $inicio, $final);
                                    $extra_data['modelo_RUNT'] = $Modelo;

                                    echo 'Modelo: ' . htmlentities($Modelo) . '<br/>';
                                    $stringData .= "Modelo: " . ($Modelo) . "\n";

                                //Color
                                    $idColor = 'Color:'; 
                                    $posColor = stripos($trimModelo, $idColor) + strlen($idColor); 
                                    $trimColor = substr($trimModelo, $posColor); //echo '<br/> TRIM: '.htmlentities($trimColor).'<br/>';

                                    $inicio = stripos($trimColor, '<td class="col_sinbordeder">' )+ strlen('<td class="col_sinbordeder">') ;
                                    $final =  stripos(substr($trimColor, $inicio), '</td>');

                                    $Color = substr($trimColor, $inicio, $final);
                                    $extra_data['color'] = $Color;

                                    echo 'Color: ' . htmlentities($Color) . '<br/>';
                                    $stringData .= "Color: " . ($Color) . "\n";

                                //Nro de serie
                                    $idSerie = 'Nro. de serie:'; 
                                    $posSerie = stripos($trimColor, $idSerie) + strlen($idSerie); 
                                    $trimSerie = substr($trimColor, $posSerie); //echo '<br/> TRIM: '.htmlentities($trimColor).'<br/>';

                                    $inicio = stripos($trimSerie, '<td class="col_conbordeder">' )+ strlen('<td class="col_conbordeder">') ;
                                    $final =  stripos(substr($trimSerie, $inicio), '</td>');

                                    $Serie = substr($trimSerie, $inicio, $final);
                                    $extra_data['nro_serie'] = $Serie;

                                    echo 'Serie: ' . htmlentities($Serie) . '<br/>';
                                    $stringData .= "Serie: " . ($Serie) . "\n";

                                //Nro. de motor:
                                    $idMotor = 'Nro. de motor:'; 
                                    $posMotor = stripos($trimSerie, $idMotor) + strlen($idMotor); 

                                    $trimMotor = substr($trimSerie, $posMotor); //echo '<br/> TRIM: '.htmlentities($trimColor).'<br/>';

                                    $inicio = stripos($trimMotor, '<td class="col_sinbordeder">' )+ strlen('<td class="col_sinbordeder">') ;
                                    $final =  stripos(substr($trimMotor, $inicio), '</td>');

                                    $Motor = substr($trimMotor, $inicio, $final);
                                    $extra_data['nro_motor'] = $Motor;

                                    echo 'Nro. de motor: ' . htmlentities($Motor) . '<br/>';
                                    $stringData .= "Nro. de motor: " . ($Motor) . "\n";

                                //Nro. de chasis
                                    $idChasis = 'Nro. de chasis:'; 
                                    $posChasis = stripos($trimMotor, $idChasis) + strlen($idChasis); 
                                    $trimChasis = substr($trimMotor, $posChasis); //echo '<br/> TRIM: '.htmlentities($trimColor).'<br/>';

                                    $inicio = stripos($trimChasis, '<td class="col_conbordeder">' )+ strlen('<td class="col_conbordeder">') ;
                                    $final =  stripos(substr($trimChasis, $inicio), '</td>');

                                    $Chasis = substr($trimChasis, $inicio, $final);
                                    $extra_data['nro_chasis'] = $Chasis;

                                    echo 'Nro. de chasis: ' . htmlentities($Chasis) . '<br/>';
                                    $stringData .= "Nro. de chasis: " . ($Chasis) . "\n";

                                //Nro. de VIN
                                    $idVin = 'Nro. de VIN:'; 
                                    $posVin = stripos($trimChasis, $idVin) + strlen($idChasis); 
                                    $trimVin = substr($trimChasis, $posVin); //echo '<br/> TRIM: '.htmlentities($trimColor).'<br/>';

                                    $inicio = stripos($trimVin, '<td class="col_sinbordeder">' )+ strlen('<td class="col_sinbordeder">') ;
                                    $final =  stripos(substr($trimVin, $inicio), '</td>');

                                    $Vin = substr($trimVin, $inicio, $final);
                                    $extra_data['nro_vin'] = $Vin;

                                    echo 'Nro. de VIN: ' . htmlentities($Vin) . '<br/>';
                                    $stringData .= "Nro. de VIN: " . ($Vin) . "\n";

                                //Cilindraje
                                    $idCilindraje = 'Cilindraje:'; 
                                    $posCilindraje = stripos($trimVin, $idCilindraje) + strlen($idCilindraje); 
                                    $trimCilindraje = substr($trimVin, $posCilindraje); //echo '<br/> TRIM: '.htmlentities($trimColor).'<br/>';

                                    $inicio = stripos($trimCilindraje, '<td class="col_conbordeder">' )+ strlen('<td class="col_conbordeder">') ;
                                    $final =  stripos(substr($trimCilindraje, $inicio), '</td>');

                                    $Cilindraje = substr($trimCilindraje, $inicio, $final);
                                    $extra_data['cilindraje'] = $Cilindraje;

                                    echo 'Cilindraje: ' . htmlentities($Cilindraje) . '<br/>';
                                    $stringData .= "Cilindraje: " . ($Cilindraje) . "\n";

                                //Tipo de carrocería
                                    $idCarroceria = 'Tipo de carrocer&iacute;a:'; 
                                    $posCarroceria = stripos($trimCilindraje, $idCarroceria) + strlen($idCarroceria); 
                                    $trimCarroceria = substr($trimCilindraje, $posCarroceria); //echo '<br/> TRIM: '.htmlentities($trimColor).'<br/>';

                                    $inicio = stripos($trimCarroceria, '<td class="col_sinbordeder">' )+ strlen('<td class="col_sinbordeder">') ;
                                    $final =  stripos(substr($trimCarroceria, $inicio), '</td>');

                                    $carroceria = substr($trimCarroceria, $inicio, $final);
                                    $extra_data['carroceria'] = $carroceria;

                                    echo 'Tipo de carrocer&iacute;a: ' . htmlentities($carroceria) . '<br/>';
                                    $stringData .= "Tipo de carrocer&iacute;a: " . ($carroceria) . "\n";


                                //Capacidad de carga
                                    $idCarga = 'Capacidad de carga:'; 
                                    $posCarga = stripos($trimCarroceria, $idCarga) + strlen($idCarga); 
                                    $trimCarga = substr($trimCarroceria, $posCarga); //echo '<br/> TRIM: '.htmlentities($trimColor).'<br/>';

                                    $inicio = stripos($trimCarga, '<td class="col_conbordeder">' )+ strlen('<td class="col_conbordeder">') ;
                                    $final =  stripos(substr($trimCarga, $inicio), '</td>');

                                    $Carga = substr($trimCarga, $inicio, $final);
                                    $extra_data['capacidad_carga'] = $Carga;

                                    echo 'Capacidad de carga: ' . htmlentities($Carga) . '<br/>';
                                    $stringData .= "Capacidad de carga: " . $Carga . "\n";

                                //Peso bruto vehícular
                                    $idPeso = 'Peso bruto veh&iacute;cular:'; 
                                    $posPeso = stripos($trimCarga, $idPeso) + strlen($idPeso); 
                                    $trimPeso = substr($trimCarga, $posPeso); //echo '<br/> TRIM: '.htmlentities($trimColor).'<br/>';

                                    $inicio = stripos($trimPeso, '<td class="col_sinbordeder">' )+ strlen('<td class="col_sinbordeder">') ;
                                    $final =  stripos(substr($trimPeso, $inicio), '</td>');

                                    $Peso = substr($trimPeso, $inicio, $final);
                                    $extra_data['peso'] = $Peso;

                                    echo 'Peso bruto veh&iacute;cular: ' . htmlentities($Peso) . '<br/>';
                                    $stringData .= "Peso bruto veh&iacute;cular: " . $Peso . "\n";

                                //Nro. de ejes
                                    $idEjes = 'Nro. de ejes:'; 
                                    $posEjes = stripos($trimPeso, $idEjes) + strlen($idEjes); 
                                    $trimEjes = substr($trimPeso, $posEjes); //echo '<br/> TRIM: '.htmlentities($trimColor).'<br/>';

                                    $inicio = stripos($trimEjes, '<td class="col_conbordeder">' )+ strlen('<td class="col_conbordeder">') ;
                                    $final =  stripos(substr($trimEjes, $inicio), '</td>');

                                    $Ejes = substr($trimEjes, $inicio, $final);
                                    $extra_data['num_ejes'] = $Ejes;

                                    echo 'Nro. de ejes: ' . htmlentities($Ejes) . '<br/>';
                                    $stringData .= "Nro. de ejes: " . $Ejes . "\n";

                                    $this->usuario_model->actualizar_vehiculo_usuario($vehiculo->id_usuario_vehiculo, '', '', '', '', '', '', $extra_data);
                                endif;
                            }
                            $this->guardarLog("legales", $stringData);
                        }
                    }
                }
                $this->usuario_model->agregar_cronjob('legales');
            endif;
        }
    }

    /**
     * función que retorna los días para el vencimiento del SOAT y tecnomecánica
     * @param vehiculo $vehiculo
     * @return array tareas a realizar 
     */
    private function dar_dias_SOAT_tecnicomecanica($vehiculo) {
        $this->load->helper('date');
        $this->load->model('usuario_model');
        $fecha_actual = mdate("%Y-%m-%d");
        $dias = array();
        $dias['soat'] =  false;
        $dias['tecnomecanica'] = false;

        
        $fecha_SOAT = $this->usuario_model->dar_legales_SOAT($vehiculo->id_usuario_vehiculo)->ultima_fecha;
        if (isset($fecha_SOAT) && $fecha_SOAT != '' && $fecha_SOAT != null && $fecha_SOAT != '0000-00-00' && strrpos($fecha_SOAT, '0000') == false) {
            $diff_fecha_SOAT = round((strtotime($fecha_actual) - strtotime($fecha_SOAT)) / (60 * 60 * 24));
            $dias['soat'] = $diff_fecha_SOAT;
        }    

        $fecha_Tecnomecanica = $this->usuario_model->dar_legales_Tecnomecanica($vehiculo->id_usuario_vehiculo)->ultima_fecha;
        if (isset($fecha_Tecnomecanica) && $fecha_Tecnomecanica != '' && $fecha_Tecnomecanica != null && $fecha_Tecnomecanica != '0000-00-00' && strrpos($fecha_Tecnomecanica, '0000') == false) {
            $diff_fecha_tecnomecanica = round((strtotime($fecha_actual) - strtotime($fecha_Tecnomecanica)) / (60 * 60 * 24));
            $dias['tecnomecanica'] = $diff_fecha_tecnomecanica;
        }       
        return $dias;
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
