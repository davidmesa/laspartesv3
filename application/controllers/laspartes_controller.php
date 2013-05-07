<?php
/* 
 * Controlador con métodos genéricos
 */
class Laspartes_Controller extends CI_Controller
{
    /**
     * Constructor de la clase
     * Lo que carga lo necesita para el footer y para el carrito de compras
     */
    function __construct()
    {
        parent::__construct();
        
        $this->load->library('cart');
        $this->load->model('autoparte_model');
        $this->load->model('establecimiento_model');
        $this->load->model('pregunta_model');

        define("CHARSET", "iso-8859-1");
    }
    
    /**
     * Metodo que escribe un log en la dirección resources/logs/..
     * @param type $tipo tipo de log que se quiere escribir.
     * @param type $log mensaje que se desea escribir.
     */
    function guardarLog($tipo, $log){
        $this->load->helper('date');
        setlocale(LC_ALL,'es_ES');
        
        $fecha = 'realizado el: '.strftime("%B %d de %Y").' ';
        $fecha = $fecha.$log; 
        $log = $fecha;
        if($tipo == "kilometraje"){
            $myFile = "resources/logs/kilometraje.txt";
        }else if($tipo == "legales"){
            $myFile = "resources/logs/legales.txt";
        }else if($tipo == "tareas"){
            $myFile = "resources/logs/tareas.txt";
        }else if($tipo == "noticias"){
            $myFile = "resources/logs/noticias.txt";
        }else{
            $myFile = "resources/logs/".$tipo.".txt";
        }
        $fh = fopen($myFile, 'a') or die("can't open file");
        fwrite($fh, $log);
        fclose($fh);
    }
    
    
    //arregla los caracteres especiales para enviar la peticón a POL
    function fix_caracteres($string){
        $string = htmlentities($string, ENT_QUOTES, 'UTF-8');
        htmlspecialchars_decode($string, ENT_NOQUOTES);
        
        return $string;
        
    }
    
    //Valida si existe una sesion activa
    //en caso de que la sesión este activa, retorna true, de lo contrario false
    function hay_sesion_activa(){
        $sesion = $this->session->userdata('esta_registrado');
        if($sesion == false || !isset($sesion)){
            return false;
        }else {
            return true;
        }
    }

}
?>
