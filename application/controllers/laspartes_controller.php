<?php
/* 
 * Controlador con métodos genéricos
 */
class Laspartes_Controller extends CI_Controller
{
    var $key = 'x8o00zdl7a9r0ko';
    var $secret = '9thr39k2n62gmx7';

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
        date_default_timezone_set('America/Bogota');
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
        $fh = fopen($myFile, 'a') or die("No se pudo abrir el archivo");
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

    /**
     * METODOS DEL DROPBOX
     */
    // Call this method first by visiting http://SITE_URL/example/request_dropbox
    public function request_dropbox($token, $secret)
    {
        $this->load->model('usuarios_dropbox_model');
        $params['key'] = $this->key;
        $params['secret'] = $this->secret;
        $usuarios_dropbox_model = new usuarios_dropbox_model();
        $usuarios_dropbox_model->dar_por_filtros(array('id_usuario' => $this->session->userdata('id_usuario')));
        if(!empty($token) && !empty($secret)){
            $params['access'] = array('oauth_token'=>urlencode($token),
                                  'oauth_token_secret'=>urlencode($secret));
            $this->load->library('dropbox', $params);
            return json_encode(array('status' => true));
        }else if(empty($usuarios_dropbox_model->id)){
            $this->load->library('dropbox', $params);
            $data = $this->dropbox->get_request_token(site_url("laspartes_controller/access_dropbox"));
            $this->session->set_userdata('token_secret', $data['token_secret']);
            return json_encode(array('status' => false, 'dbsesion' => 'Debes iniciar sesión en dropbox.', 'dburl' =>$data['redirect']));
        }else{
            $this->session->set_userdata('oauth_token', $usuarios_dropbox_model->oauth_token);
            $this->session->set_userdata('oauth_token_secret', $usuarios_dropbox_model->oauth_token_secret);
            $params['access'] = array('oauth_token'=>urlencode($this->session->userdata('oauth_token')),
                                  'oauth_token_secret'=>urlencode($this->session->userdata('oauth_token_secret')));
            $this->load->library('dropbox', $params);
            return json_encode(array('status' => true));
        }
    }

    //This method should not be called directly, it will be called after 
    //the user approves your application and dropbox redirects to it
    public function access_dropbox()
    {
        $this->load->model('usuarios_dropbox_model');
        $params['key'] = 'x8o00zdl7a9r0ko';
        $params['secret'] = '9thr39k2n62gmx7';
        
        $this->load->library('dropbox', $params);
        
        $oauth = $this->dropbox->get_access_token($this->session->userdata('token_secret'));

        $usuarios_dropbox_model = new usuarios_dropbox_model();
        $usuarios_dropbox_model->id_usuario = $this->session->userdata('id_usuario');
        $usuarios_dropbox_model->oauth_token = $oauth['oauth_token'];
        $usuarios_dropbox_model->oauth_token_secret = $oauth['oauth_token_secret'];
        $usuarios_dropbox_model->insertar();
        
        $this->session->set_userdata('oauth_token', $oauth['oauth_token']);
        $this->session->set_userdata('oauth_token_secret', $oauth['oauth_token_secret']);
        redirect('laspartes_controller/closeWindow');
    }

    public function closeWindow(){
        echo '<script>window.close();</script>';
    }

    /**
     * FIN METODOS DEL DROPBOX
     */

}
?>
