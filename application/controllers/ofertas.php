<?php

require_once 'laspartes_controller.php'; 

//error_reporting(E_ALL);
//ini_set('display_errors', '1');

/**
 * Clase que maneja la página principal
 */
class Ofertas extends Laspartes_Controller {

    /**
     * Constructor de la clase Inicio
     */
    function __construct() {
        parent::__construct();
    }

    /**
     * Muestra la página principal
     */
    function index() {
//        $this->load->helper('date');
//        $this->load->model('usuario_model');
//        setlocale(LC_ALL, 'es_ES');
//        $ofertas = $this->usuario_model->dar_ofertas_usuarios();
//
//        foreach ($ofertas as $oferta):
//            $ofertaTemp = $this->usuario_model->dar_ofertas_usuario($oferta->id_usuario);
//            foreach ($ofertaTemp as $temp) {
//                $this->_enviarOferta($temp);
//            }
//        endforeach;
    }

    /**
     *  Encargado de enviar la oferta vía correo electrónico
     * @param type $oferta 
     */
    function _enviarOferta($oferta) {
        $this->load->helper('mail');
        $data['oferta'] = $oferta;
        ob_start();
        if($oferta->id_oferta < 56 ){
            $this->load->view('newsletter/ofertaEsclusivaHTML', $data);
            $contenidoHTML = ob_get_contents();
        ob_end_clean();
        $destinatario = new stdClass();
        $destinatarios = array();
        $destinatario->email = $oferta->email;
        $destinatario->nombres = $oferta->nombres . " " . $oferta->apellidos;
        $destinatarios[] = $destinatario;
        echo $contenidoHTML;
        send_mail($destinatarios, "Ahorra hasta un -60% en Cambios de Aceite y revisiones de 10mil, 50mil... comprando a traves de Laspartes.com", $contenidoHTML, "", "");
        }
        else if($oferta->id_oferta >= 56 && $oferta->id_usuario == 54){
            $this->load->view('newsletter/ofertaEsclusivaLlantasHTML', $data);
        $contenidoHTML = ob_get_contents();
        ob_end_clean();
        $destinatario = new stdClass();
        $destinatarios = array();
        $destinatario->email = $oferta->email;
        $destinatario->nombres = $oferta->nombres . " " . $oferta->apellidos;
        $destinatarios[] = $destinatario;
        echo $contenidoHTML;
        send_mail($destinatarios, "Ahorra hasta un -27% en cambios de llantas comprando a traves de Laspartes.com", $contenidoHTML, "", "");
        }
            
    }

    function dar_oferta($id_oferta, $id_usuario) {
        $this->load->model('generico_model');
        $set = array();
        $setId[] = 'id_usuario';
        $setId[] = $id_usuario;
        $set[] = $setId;
        $setSitio[] = 'sitio_click';
        $setSitio[] = 'click en el email';
        $set[] = $setSitio;
        $this->generico_model->agreagar_registros_genericos('oferta_esclusiva', $set);
        $this->load->model('usuario_model');
        $oferta = $this->usuario_model->dar_oferta($id_oferta);
        $llave_encripcion = "13733cb5a73";
        $usuarioId = "84442";
        $refVenta = time();
        $iva = $oferta->iva;
        $valor = $oferta->precio;
        $baseDevolucionIva = $valor - $iva;
        $moneda = "COP";
        $descripcion = $oferta->titulo;
        $url_respuesta = base_url() . "ofertas/respuesta_pago";
        $url_confirmacion = base_url() . "ofertas/url_confirmacion";
        $firma_cadena = "$llave_encripcion~$usuarioId~$refVenta~$valor~$moneda";
        $firma = md5($firma_cadena);
        $data['llave_encripcion'] = $llave_encripcion;
        $data['usuarioId'] = $usuarioId;
        $data['refVenta'] = $refVenta;
        $data['iva'] = $iva;
        $data['baseDevolucionIva'] = $baseDevolucionIva;
        $data['valor'] = $valor;
        $data['moneda'] = $moneda;
        $data['descripcion'] = $descripcion;
        $data['url_respuesta'] = $url_respuesta;
        $data['url_confirmacion'] = $url_confirmacion;
        $data['firma_cadena'] = $firma_cadena;
        $data['firma'] = $firma;
//        echo 'header("Location:" . "http://www.laspartes.com/promociones");';
        if($id_oferta< 56){
             $this->load->view('ofertas/oferta_view', $data);
        }else{
            $this->load->view('ofertas/oferta_view_1', $data);
        }
       
    }

    function respuesta_pago() {

//        $llave = "13733cb5a73"; 
        $uri = $_SERVER['REQUEST_URI'];
        list($ur, $usu, $datos) = split('/', $uri);
        $uri = $datos;
        list($l1, $l2) = split('\?', $uri);
        $uri = $l2;
        $array = split('&', $uri);
        $valores = array();
        foreach ($array as $row) {
            list($val1, $val2) = split('=', $row);
            $valores[$val1] = $val2;
        }
//        $usuario_id = $valores[usuario_id];
//        $ref_venta = $valores[ref_venta];
//        $valor = $valores[valor];
//        $moneda = $valores[moneda];
        $estado_pol = $valores[estado_pol];
        $mensaje = $valores[mensaje];
        if ($estado_pol == 6) {
            //transacción fallida
            $data['respuesta'] = "Transacci&oacute;n fallida!";
            $data['mensaje'] = "El pago no se debito de tu cuenta vuelve a intentar hacer la compra por favor.";
            $this->load->view('POL/respuesta_POL', $data);
        } else if ($estado_pol == 12) {
            $estadoTx = "";
            //transaccion pendiente
            $data['respuesta'] = "Tu transacci&oacute;n se encuentra pendiente!";
            $data['mensaje'] = "Pendiente, Por favor revisar si el d&eacute;bito fue realizado en el Banco";
            $this->load->view('POL/respuesta_POL', $data);
        } else if ($estado_pol == 4) {
            //transaccion aprobada
            $data['respuesta'] = "Felicitaciones tu transacci&oacute;n ha sido Aprobada!";
            $data['mensaje'] = "El pago fue debitado de tu cuenta, dentro de poco nos comunicaremos contigo para concretar la entrega del producto.";
            $this->load->view('POL/respuesta_POL', $data);
        } else if ($estado_pol == 7) {
            //transacción en validacion
            $data['respuesta'] = "Tu transacción se encuentra en validación!";
            $data['mensaje'] = "Tu pago está siendo confirmado para procesar tu orden no intentes hacer la compra por el mismo producto hasta que recibas un correo con el estado de la transacción.";
            $this->load->view('POL/respuesta_POL', $data);
        } else {
            //transacción en validacion
            $data['respuesta'] = $mensaje;
            $this->load->view('POL/respuesta_POL', $data);
        }
    }

    function _generar_factura($email) {
        setlocale(LC_ALL, 'es_ES');
        define("CHARSET", "iso-8859-1");



        $mensajeCorreo = "Gracias por tu compra, en las pr&oacute;ximas horas, a su cuenta de correo electr&oacute;nico registrada al momento del pago, le notificaremos la aprobaci&oacute;n o rechazo de su transacci&oacute;n.";

        $destinatarios = array();
        $destinatario = new stdClass();
        $destinatario->email = $email;
        $destinatarios[] = $destinatario;
        $destinatario = new stdClass();
        $destinatario->email = "tallerenlinea@laspartes.com.co";
        $destinatarios[] = $destinatario;
        $this->load->helper('mail');
        send_mail($destinatarios, "Factura de compra LasPartes.com - " . strftime("%B %d de %Y"), "", $mensajeCorreo, '');
    }

    function url_confirmacion() {
        $llave = "13733cb5a73";
        $usuario_id = $_REQUEST['usuario_id'];
        $ref_venta = $_REQUEST['ref_venta'];
        $valor = $_REQUEST['valor'];
        $moneda = $_REQUEST['moneda'];
        $estado_pol = $_REQUEST['estado_pol'];
        $firma_cadena = "$llave~$usuario_id~$ref_venta~$valor~$moneda~$estado_pol";
        $firmacreada = md5($firma_cadena);
        $firma = $_REQUEST['firma'];
        $ref_venta = $_REQUEST['ref_venta'];
        $email = $_REQUEST['emailComprador'];
        $fecha_procesamiento = $_REQUEST['fecha_procesamiento'];
//        $codigo_respuesta = $_REQUEST['codigo_respuesta_pol'];
        $estadoTx = "";
        if (strtoupper($firma) == strtoupper($firmacreada)) {//comparacion de las firmas para comprobar que los datos si vienen de Pagosonline
            if ($_REQUEST['estado_pol'] == 6) {
                $estadoTx = "Transacción fallida";
            } else if ($estado_pol == 6) {
                $estadoTx = "Transacción rechazada";
            } else if ($_REQUEST['estado_pol'] == 12) {
                $estadoTx = "Pendiente, Por favor revisar si el débito fue realizado en el Banco";
            } else if ($_REQUEST['estado_pol'] == 4) {
                $estadoTx = "Transacción aprobada";
                $this->_generar_factura($email);
            } else if ($estado_pol == 7) {
                //transacción en validacion
                $estadoTx = "Transacción se encuentra en validación";
            } else {
                $estadoTx = $_REQUEST['mensaje'];
            }
            $this->guardarLog('factura', $estadoTx . ' fecha:' . $fecha_procesamiento);
        }
    }

    function registrar_movimiento() {
        $this->load->library('form_validation');
        $reglas = array(
            array(
                'field' => 'id_usuario',
                'label' => 'identificador del usuario',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'mensaje',
                'label' => 'mensaje',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'email',
                'label' => 'email',
                'rules' => 'trim|email|required|xss_clean'
            ),
            array(
                'field' => 'telefono',
                'label' => 'telefono',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'direccion',
                'label' => 'direccion',
                'rules' => 'trim|required|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);
        if (!$this->form_validation->run()) {
            echo validation_errors();
        } else {

            $id_usuario = $this->input->post('id_usuario');
            $mensaje = $this->input->post('mensaje');
            $telefono = $this->input->post('telefono');
            $direccion = $this->input->post('direccion');
            $email = $this->input->post('email');

            $this->load->model('generico_model');
            $set = array();
            $setId[] = 'id_usuario';
            $setId[] = $id_usuario;
            $set[] = $setId;
            $setSitio[] = 'sitio_click';
            $setSitio[] = $mensaje;
            $set[] = $setSitio;
            $setTelefono[] = 'telefono';
            $setTelefono[] = $telefono;
            $set[] = $setTelefono;
            $setDireccion[] = 'direccion';
            $setDireccion[] = $direccion;
            $set[] = $setDireccion;
            $setEmail[] = 'email';
            $setEmail[] = $email;
            $set[] = $setEmail;
            $this->generico_model->agreagar_registros_genericos('oferta_esclusiva', $set);
        }
    }
    
    
    function generar_firma() {
        $this->load->library('form_validation');
        $reglas = array(
            array(
                'field' => 'cantidad',
                'label' => 'cantidad',
                'rules' => 'trim|required|xss_clean|numeric'
            ),array(
                'field' => 'oferta',
                'label' => 'oferta',
                'rules' => 'trim|required|xss_clean|numeric'
            ),array(
                'field' => 'reVenta',
                'label' => 'reVenta',
                'rules' => 'trim|required|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);
        if (!$this->form_validation->run()) {
            echo validation_errors();
        } else {
            $this->load->model('usuario_model');
            $id_oferta = $this->input->post('oferta');
            $cantidad = $this->input->post('cantidad');
            $refVenta = $this->input->post('reVenta');
             $oferta = $this->usuario_model->dar_oferta($id_oferta);
            $llave_encripcion = "13733cb5a73";
            $usuarioId = "84442";
            $moneda = "COP";
            $valor = $oferta->precio * $cantidad;
            $firma_cadena = "$llave_encripcion~$usuarioId~$refVenta~$valor~$moneda";
            echo md5($firma_cadena);
        }
    }

}