<?php

require_once 'laspartes_controller.php';

error_reporting(E_ALL);
ini_set('display_errors', '1');


/**
 * Clase que maneja la página principal
 */
class ActualizarKilometraje extends Laspartes_Controller{

	/**
	 * Constructor de la clase Inicio
	 */
	function __construct(){
		parent::__construct();
	}

	/**
	 * Muestra la página principal
	 */
	function index($dataP = array()){
                $this->load->helper('date');
		$hashValidation = $this->input->post('param');
		if(isset($hashValidation) && $this->validarHash($hashValidation)){
			$this->load->model('usuario_model');
                        $ultimo_cronjob = $this->usuario_model->dar_ultimo_cronjob_tipo('kilometraje');
                        $diff_en_dias = 0;
                        if(sizeof($ultimo_cronjob)==1){
                            $ultima_fecha = $ultimo_cronjob->fecha;
                            $diff = abs(strtotime(mdate("%Y-%m-%d")) - strtotime($ultima_fecha));
                            $diff_en_dias = ($diff/(60*60*24));
                        }
                        if (sizeof($ultimo_cronjob)== 0 || $diff_en_dias > 0 ):
                            echo "se esta realizando el cromjob de actualizar kilometraje de todos los usuarios";
                            $usuarios = array();
                            $usuarios = $this->usuario_model->dar_usuarios();
                            foreach($usuarios as $usuario){
                                    $ciudad = $usuario->lugar;
                                    $kilometraje = $this->usuario_model->dar_kilometraje_ciudad($ciudad);

                                    $kilometraje_diario = $kilometraje/365;
                                    $vehiculos_usuario = $this->usuario_model->dar_vehiculos_usuario($usuario->id_usuario);
                                    foreach($vehiculos_usuario as $vehiculo){

                                            $kilometraje_anterior= $vehiculo->kilometraje;
                                            $nuevo_kilometraje = $vehiculo->kilometraje + $kilometraje_diario;
                                            $this->usuario_model->modificar_kilometraje_vehiculo($vehiculo->id_usuario_vehiculo, round( $nuevo_kilometraje) );
                                            
                                            //se escribe el log de actualizaciones

                                            $stringData = "ID_usuario: ".$usuario->id_usuario." Vehiculo:".$vehiculo->id_vehiculo." Kilometraje anterior: ".$kilometraje_anterior." Kilometraje actual: ".round($nuevo_kilometraje)."\n";
                                            $this->guardarLog("kilometraje", $stringData);

                                    }
                            }
                            $this->usuario_model->agregar_cronjob('kilometraje');
                    endif;
		}
	}
	
	function validarHash($hash = ''){
		$fecha1 = date('Y-F-d');
		$fecha2 = date('Y-m-d');
		$hash1 = md5($fecha1);
		$hash2 = md5($fecha2);
		$param = $hash1."|".$hash2;
		
		return strcmp($hash, $param) == 0;
	}
}
