<?php

require_once 'laspartes_controller.php';

/**
 * Clase que maneja las autopartes, categorías y marcas de autopartes
 */
class Autopartes extends Laspartes_Controller{

    /**
     * Constructor de la clase Autoparte
     */
    function __construct(){
        parent::__construct();
    }

    /**
     * Da detalles de una autoparte
     * @param int $id_autoparte
     * @param String $orden
     * @return array con $autoparte, $autoparte_vehiculos, $marcas, $establecimientos
     */
    function _ver_autoparte($id_autoparte, $orden, $categoria, $marca, $vehiculoMarca, $vehiculoLinea){
        $this->load->model('autoparte_model');
        $this->load->model('establecimiento_model');
        $this->load->model('usuario_model');
        $this->load->model('vehiculo_model');
        $this->autoparte_model->actualizar_numero_visitas($id_autoparte);
        $data['autoparte'] = $this->autoparte_model->dar_autoparte($id_autoparte);
        $data['rango_precios'] = $this->autoparte_model->dar_autoparte_rango_precios($id_autoparte);
        $data['autoparte_vehiculos'] = $this->autoparte_model->dar_autoparte_vehiculos($id_autoparte);
        $data['vehiculos_marcas'] = $this->autoparte_model->dar_autoparte_vehiculos_distinct($id_autoparte);
//        $data['marcas'] = $this->autoparte_model->dar_autopartes_marcas();
        $data['establecimientos'] = $this->establecimiento_model->dar_establecimientos_autoparte($id_autoparte, $orden);
        
        //-----------
        $a = str_replace('-', ' ', convert_accented_characters($categoria));
        $b = str_replace('-', ' ', convert_accented_characters($marca));
        $c = str_replace('-', ' ', convert_accented_characters($vehiculoMarca));
        $d = str_replace('-', ' ', convert_accented_characters($vehiculoLinea));
        $data['cantidadAutopart'] = (int)(sizeof($this->autoparte_model->dar_autopartes_paginacion_filtros_cantidad($a, $b, $c, $d))/10);
        $data['categorias'] = $this->autoparte_model->dar_autopartes_categorias_filtros($b, $c, $d);
        $data['marcas'] = $this->autoparte_model->dar_autopartes_marcas_filtros($a, $c, $d);
        
        $data['allvehiculos'] = $this->vehiculo_model->dar_vehiculos();
        $index = 0;
        foreach ($data['allvehiculos'] as $vehiculo) {
            $data['allvehiculos'][$index]->label = str_replace(" ","_", $vehiculo->marca) . ' ' . $vehiculo->linea;
            $data['allvehiculos'][$index]->value = str_replace(" ","_", $vehiculo->marca) . ' ' . $vehiculo->linea;
            $index++;
        }
        return $data;
    }

    /**
     *
     * @param int $limit
     * @param int $offset
     * @param String $categoria
     * @param String $marca
     * @return array con $autopartes, autopartes_vehículos, categorías y marcas
     */
    function _ver_autopartes($limit, $offset, $orden, $categoria, $marca, $marca_vehiculo, $linea_vehiculo){
        $offset = $offset -1;
        $this->load->model('autoparte_model');
        $this->load->model('usuario_model');
        $this->load->model('vehiculo_model');
        $this->load->library('pagination');
        $a = str_replace('-', ' ', convert_accented_characters($categoria));
        $b = str_replace('-', ' ', convert_accented_characters($marca));
        $c = str_replace('-', ' ', convert_accented_characters($marca_vehiculo));
        $d = str_replace('-', ' ', convert_accented_characters($linea_vehiculo));
        $data['autopartes'] = $this->autoparte_model->dar_autopartes_paginacion_filtros($limit, $offset, $orden, $a, $b, $c, $d);
        $data['cantidadAutopart'] = (int)(sizeof($this->autoparte_model->dar_autopartes_paginacion_filtros_cantidad($a, $b, $c, $d))/10)+1;
        $data['categorias'] = $this->autoparte_model->dar_autopartes_categorias_filtros($b, $c, $d);
        $data['marcas'] = $this->autoparte_model->dar_autopartes_marcas_filtros($a, $b, $c, $d);
        
        $data['allvehiculos'] = $this->vehiculo_model->dar_vehiculos();
        $index = 0;
        foreach ($data['allvehiculos'] as $vehiculo) {
            $data['allvehiculos'][$index]->label = $vehiculo->marca . ' ' . $vehiculo->linea;
            $data['allvehiculos'][$index]->value = str_replace(" ","_", $vehiculo->marca) . ' ' . $vehiculo->linea;
            $index++;
        }
        
        //da la lista de marcas de vehículos para el autocomplete
        $data['allmarcas'] = $this->vehiculo_model->dar_vehiculos_marca();
        $index = 0;
        foreach ($data['allmarcas'] as $marca) {
            $data['allmarcas'][$index]->label = $marca->marca;
            $data['allmarcas'][$index]->value = str_replace(" ","_", $marca->marca);
            $index++;
        } 
        return $data;
    }

    /**
     * Muestra la lista de autopartes
     */
    function index(){
        $this->load->helper('text');
        
        $categoria;
        $marca;
        $vehiculoMarca;
        $vehiculoLinea;
        $pagina;
        $pagina = 1;
        $order = 'otro';
        if($this->uri->segment(2)){
            $url = uri_string();
            $urlArray = split("/", $url);
            for($i = 2 ; $i< sizeof($urlArray); $i++){
                if($urlArray[$i]=='vehiculo'){
                    $i++;
                    $vehiculo = $urlArray[$i];
                    $temp = split("-", $vehiculo, 2);
                    $vehiculoMarca = $temp[0];
                    $vehiculoLinea = $temp[1];
                }elseif ($urlArray[$i]=='categoria') {
                    $i++;
                    $categoria = $urlArray[$i];
                }elseif ($urlArray[$i]=='marca') {
                    $i++;
                    $marca = $urlArray[$i];
                }elseif ($urlArray[$i]=='pagina') {
                    $i++;
                    $pagina = $urlArray[$i]+0;
                }
            }
        }
        $data = $this->_ver_autopartes(10, $pagina, $order, $categoria, $marca, $vehiculoMarca, $vehiculoLinea);

        $this->load->model('generico_model');
        $data['categoriaBusqueda'] = $categoria;
        if(isset($categoria)){
            $categoriaObj = $this->generico_model->dar_tildes('autopartes_categorias', 'nombre', str_replace('-', ' ', $categoria));
            $data['categoriaBusqueda'] = $categoriaObj->nombre;
        }
        $data['marcaBusqueda'] = $marca;
        if(isset($marca)){
            $marcaObj = $this->generico_model->dar_tildes('autopartes_marcas', 'nombre', str_replace('-', ' ',$marca));
            $data['marcaBusqueda'] = $marcaObj->nombre;
        }
        $data['vehiculoMarcaBusqueda'] = $vehiculoMarca;
        if(isset($vehiculoMarca)){
            $marcaVehObj = $this->generico_model->dar_tildes('vehiculos', 'marca', str_replace('_', ' ',$vehiculoMarca));
            $data['vehiculoMarcaBusqueda'] = $marcaVehObj->marca;
        }
        $data['vehiculoLineaBusqueda'] = $vehiculoLinea;
        if(isset($vehiculoLinea)){
            $marcaObj = $this->generico_model->dar_tildes('vehiculos', 'linea', str_replace('-', ' ',$vehiculoLinea));
            $data['vehiculoLineaBusqueda'] = $marcaObj->linea;
        }
        
        $data['orden'] = $orden;
        $data['limit'] = $pagina;
        $keywords = '';
        foreach ($data['categorias'] as $servi):
            $keywords .= ','.$servi->nombre;
        endforeach;
        $data['metaKeywords'] = 'autopartes,repuestos,bogota,repuestos renault,repuestos chevrolet,repuestos kia,repuestos hyundai,repuestos mazda'.$keywords;
        $data['metaDescripcion'] = 'Encuentra la autoparte que necesitas de forma fácil, rápida y segura. Envíos a todo el país';
        $data['metaImagen'] = 'resources/images/home/noticias/baner-autopartes.png';
        $data['titulo'] = 'Laspartes.com :: Autopartes';
        $data['breadcrumb'] = '<div><a href="' . base_url() . '">Inicio</a></div> <div class="div-breadcrumb-espaciador"></div> <div>Autopartes</div>';
        $data['header_view'] = 'autoparte/header/autoparte_lista_view';
        $data['navegacion_view'] = 'autopartes';
        $data['contenido_view'] = 'autoparte/autoparte_lista_view';
        $this->load->view('template/template', $data);
    }

    /**
     * Muestra el detalle de una autoparte
     */
    function ver_autoparte($id_autoparte, $nombre_autoparte){
        $categoria;
        $marca;
        $vehiculoMarca;
        $vehiculoLinea;
        $pagina = 0;
        $orden = 'precio';
        if($this->uri->segment(3)){
            $url = uri_string();
            $urlArray = split("/", $url);
            for($i = 2 ; $i< sizeof($urlArray); $i++){
                if($urlArray[$i]=='vehiculo'){
                    $i++;
                    $vehiculo = $urlArray[$i];
                    $temp = split("-", $vehiculo, 2);
                    $vehiculoMarca = $temp[0];
                    $vehiculoLinea = $temp[1];
                }elseif ($urlArray[$i]=='categoria') {
                    $i++;
                    $categoria = $urlArray[$i];
                }elseif ($urlArray[$i]=='marca') {
                    $i++;
                    $marca = $urlArray[$i];
                }elseif ($urlArray[$i]=='pagina') {
                    $i++;
                    $pagina = $urlArray[$i]+0;
                }
            }
        }
        
        $data = $this->_ver_autoparte($id_autoparte, $orden, $categoria, $marca, $vehiculoMarca, $vehiculoLinea);
        
        $this->load->model('generico_model');
            $data['categoriaBusqueda'] = $categoria;
            if(isset($categoria)){
                $categoriaObj = $this->generico_model->dar_tildes('autopartes_categorias', 'nombre', str_replace('-', ' ', $categoria));
                $data['categoriaBusqueda'] = $categoriaObj->nombre;
            }
            $data['marcaBusqueda'] = $marca;
//            if(isset($marca)){
//                $marcaObj = $this->generico_model->dar_tildes('autopartes_marcas', 'nombre', str_replace('-', ' ',$marca));
//                $data['marcaBusqueda'] = $marcaObj->nombre;
//            }
            $data['vehiculoMarcaBusqueda'] = $vehiculoMarca;
            if(isset($vehiculoMarca)){
                $marcaVehObj = $this->generico_model->dar_tildes('vehiculos', 'marca', str_replace('-', ' ',$vehiculoMarca));
                $data['vehiculoMarcaBusqueda'] = $marcaVehObj->marca;
            }
            $data['vehiculoLineaBusqueda'] = $vehiculoLinea;
            if(isset($vehiculoLinea)){
                $marcaObj = $this->generico_model->dar_tildes('vehiculos', 'linea', str_replace('-', ' ',$vehiculoLinea));
                $data['vehiculoLineaBusqueda'] = $marcaObj->linea;
            }

        if(sizeof($data['autoparte'])==0 || $data['autoparte']->estado=='No Activo'){
            $data['titulo'] = 'Página no Encontrada';
            $data['breadcrumb'] = '<div><a href="' . base_url() . '">Inicio</a></div> <div class="div-breadcrumb-espaciador"></div> <div><a href="'.base_url().'autopartes">Autopartes</a></div><div class="div-breadcrumb-espaciador"></div><div>Página no encontrada - Lo sentimos</div>';
            $data['header_view'] = 'error/404/header/404_view';
            $data['navegacion_view'] = 'autopartes';
            $data['contenido_view'] = 'error/404/404_view';
            $this->load->view('template/template', $data);
        }
        else{
            $keywords = '';
            foreach ($data['autoparte_vehiculos'] as $servi):
                $keywords .= ','.$servi->marca.' '.$servi->linea;
            endforeach;
            $data['metaKeywords'] = $data['autoparte']->nombre.$keywords;
            $data['metaDescripcion'] = character_limiter($data['autoparte']->descripcion, 150);
            $data['metaImagen'] = $data['autoparte']->logo_url;
            $data['orden'] = $orden;
            $data['titulo'] = $data['autoparte']->nombre;
            $data['breadcrumb'] = '<div><a href="' . base_url() . '">Inicio</a></div> <div class="div-breadcrumb-espaciador"></div> <div><a href="'.base_url().'autopartes">Autopartes</a></div><div class="div-breadcrumb-espaciador"></div><div>'.$data['autoparte']->nombre.'</div>';
            $data['header_view'] = 'autoparte/header/autoparte_detalle_view';
            $data['navegacion_view'] = 'autopartes';
            $data['contenido_view'] = 'autoparte/autoparte_detalle_view';
            $this->load->view('template/template', $data);
        }
    }
    
    function asdf897adsfl(){
        $llave_encripcion = "13733cb5a73";
        $usuarioId = "84442";
        $refVenta = time();
        $iva = 303448;
        $valor = 2200000;
        $baseDevolucionIva = $valor - $iva;
        $moneda = "COP";
        $descripcion = '4 rines originales de 16 pulgadas de brazo curvo de Mazda 6, garantía 6 meses, envío incluído';
        $url_respuesta = base_url() . "autopartes/respuesta_pago_asdf897adsfl";
        $url_confirmacion = base_url() . "autopartes/url_confirmacion_asdf897adsfl";
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
            $this->load->view('autoparte/pagoAmortiguador', $data);  
    }
    
    function respuesta_pago_asdf897adsfl(){

        $llave = "13733cb5a73"; 
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
        $usuario_id = $valores[usuario_id];
        $ref_venta = $valores[ref_venta];
        $valor = $valores[valor];
        $moneda = $valores[moneda];
        $estado_pol = $valores[estado_pol];
        $mensaje = $valores[mensaje];
        if ($estado_pol == 6 ) {
            //transacción fallida
            $data['respuesta'] = "Transacci&oacute;n fallida!";
            $data['mensaje'] = "El pago no se debito de tu cuenta vuelve a intentar hacer la compra por favor.";
            $this->load->view('POL/respuesta_POL', $data);
        }else if ($estado_pol == 12) {
            $estadoTx = "";
            //transaccion pendiente
            $data['respuesta'] = "Tu transacci&oacute;n se encuentra pendiente!";
            $data['mensaje'] = "Pendiente, Por favor revisar si el d&eacute;bito fue realizado en el Banco";
            $this->load->view('POL/respuesta_POL', $data);
        } else if ($estado_pol == 4 ) {
            //transaccion aprobada
            $data['respuesta'] = "Felicitaciones tu transacci&oacute;n ha sido Aprobada!";
            $data['mensaje'] = "El pago fue debitado de tu cuenta, dentro de poco nos comunicaremos contigo para concretar la entrega del producto.";
            $this->load->view('POL/respuesta_POL', $data);
        } else if ($estado_pol == 7) {
            //transacción en validacion
            $data['respuesta'] = "Tu transacción se encuentra en validación!";
            $data['mensaje'] = "Tu pago está siendo confirmado para procesar tu orden no intentes hacer la compra por el mismo producto hasta que recibas un correo con el estado de la transacción.";
            $this->load->view('POL/respuesta_POL', $data);
        } 
        
        else {
            //transacción en validacion
            $data['respuesta'] = $mensaje;
            $this->load->view('POL/respuesta_POL', $data);
        }

    }
    
    function _generar_factura_asdf897adsfl(){
        setlocale(LC_ALL, 'es_ES');
        define("CHARSET", "iso-8859-1");

        

         $mensajeCorreo = "Gracias por tu compra, en el archivo adjunto encontrarás la factura de tu compra!";

        $destinatarios = array();
        $destinatario = new stdClass();
        $destinatario->email = 'jorgeupegui0305@hotmail.com';
        $destinatarios[] = $destinatario;
        $destinatario = new stdClass();
        $destinatario->email = "tallerenlinea@laspartes.com.co";
        $destinatarios[] = $destinatario;
            $fileName = '10-oct-2012-jorge-upegui.pdf';
            $this->load->helper('mail');
            send_mail($destinatarios, "Factura de compra LasPartes.com - " . strftime("%B %d de %Y"), "",$mensajeCorreo ,  $fileName);

    }
    
    function url_confirmacion_asdf897adsfl(){
        $llave = "13733cb5a73"; 
        $usuario_id = $_REQUEST['usuario_id'];
        $ref_venta = $_REQUEST['ref_venta'];
        $valor = $_REQUEST['valor'];
        $moneda = $_REQUEST['moneda'];
        $estado_pol = $_REQUEST['estado_pol'];
        $firma_cadena = "$llave~$usuario_id~$ref_venta~$valor~$moneda~$estado_pol";
        $firmacreada = md5($firma_cadena); //firma que generaron ustedes
        $firma = $_REQUEST['firma']; //firma que envía nuestro sistema
        $ref_venta = $_REQUEST['ref_venta'];
        $fecha_procesamiento = $_REQUEST['fecha_procesamiento'];
        $codigo_respuesta = $_REQUEST['codigo_respuesta_pol'];
        $estadoTx = "";
        if (strtoupper($firma) == strtoupper($firmacreada)) {//comparacion de las firmas para comprobar que los datos si vienen de Pagosonline

                if ($_REQUEST['estado_pol'] == 6) {
                    $estadoTx = "Transacción fallida";
                } else if ($estado_pol == 6) {
                    $estadoTx = "Transacción rechazada";
                } else if ($_REQUEST['estado_pol'] == 12) {
                    $estadoTx = "Pendiente, Por favor revisar si el débito fue realizado en el Banco";
                } else if ($_REQUEST['estado_pol'] == 4 ) {
                    $estadoTx = "Transacción aprobada";
                    $this->_generar_factura_asdf897adsfl();
                } else if ($estado_pol == 7 ) {
                    //transacción en validacion
                    $estadoTx = "Transacción se encuentra en validación";
                } else {
                    $estadoTx = $_REQUEST['mensaje'];
                }
                $this->guardarLog('factura', $estadoTx.' fecha:'.$fecha_procesamiento);
        }
    }
    
    /** compra de giobarbosa84@hotmail.com*/
    
    function ghs089sdjkl334(){
        $llave_encripcion = "13733cb5a73";
        $usuarioId = "84442";
        $refVenta = time();
        $iva = 8800;
        $valor = 63800;
        $baseDevolucionIva = $valor - $iva;
        $moneda = "COP";
        $descripcion = 'Empaquetadura de tapa válvulas de Daihatsu Grand Move, garantía 6 meses, envío incluído';
        $url_respuesta = base_url() . "autopartes/respuesta_pago_ghs089sdjkl334";
        $url_confirmacion = base_url() . "autopartes/url_confirmacion_ghs089sdjkl334";
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
            $this->load->view('autoparte/pagoAmortiguador', $data);  
    }
    
    function respuesta_pago_ghs089sdjkl334(){

        $llave = "13733cb5a73"; 
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
        $usuario_id = $valores[usuario_id];
        $ref_venta = $valores[ref_venta];
        $valor = $valores[valor];
        $moneda = $valores[moneda];
        $estado_pol = $valores[estado_pol];
        $mensaje = $valores[mensaje];
        if ($estado_pol == 6 ) {
            //transacción fallida
            $data['respuesta'] = "Transacci&oacute;n fallida!";
            $data['mensaje'] = "El pago no se debito de tu cuenta vuelve a intentar hacer la compra por favor.";
            $this->load->view('POL/respuesta_POL', $data);
        }else if ($estado_pol == 12) {
            $estadoTx = "";
            //transaccion pendiente
            $data['respuesta'] = "Tu transacci&oacute;n se encuentra pendiente!";
            $data['mensaje'] = "Pendiente, Por favor revisar si el d&eacute;bito fue realizado en el Banco";
            $this->load->view('POL/respuesta_POL', $data);
        } else if ($estado_pol == 4 ) {
            //transaccion aprobada
            $data['respuesta'] = "Felicitaciones tu transacci&oacute;n ha sido Aprobada!";
            $data['mensaje'] = "El pago fue debitado de tu cuenta, dentro de poco nos comunicaremos contigo para concretar la entrega del producto.";
            $this->load->view('POL/respuesta_POL', $data);
        } else if ($estado_pol == 7) {
            //transacción en validacion
            $data['respuesta'] = "Tu transacción se encuentra en validación!";
            $data['mensaje'] = "Tu pago está siendo confirmado para procesar tu orden no intentes hacer la compra por el mismo producto hasta que recibas un correo con el estado de la transacción.";
            $this->load->view('POL/respuesta_POL', $data);
        } 
        
        else {
            //transacción en validacion
            $data['respuesta'] = $mensaje;
            $this->load->view('POL/respuesta_POL', $data);
        }

    }
    
    function _generar_factura_ghs089sdjkl334(){
        setlocale(LC_ALL, 'es_ES');
        define("CHARSET", "iso-8859-1");

        

         $mensajeCorreo = "Gracias por tu compra, en el archivo adjunto encontrarás la factura de tu compra!";

        $destinatarios = array();
        $destinatario = new stdClass();
        $destinatario->email = 'giobarbosa84@hotmail.com';
        $destinatarios[] = $destinatario;
        $destinatario = new stdClass();
        $destinatario->email = "tallerenlinea@laspartes.com.co";
        $destinatarios[] = $destinatario;
            $fileName = '10-oct-2012-gio-barbosa.pdf';
            $this->load->helper('mail');
            send_mail($destinatarios, "Factura de compra LasPartes.com - " . strftime("%B %d de %Y"), "",$mensajeCorreo ,  $fileName);

    }
    
    function url_confirmacion_ghs089sdjkl334(){
        $llave = "13733cb5a73"; 
        $usuario_id = $_REQUEST['usuario_id'];
        $ref_venta = $_REQUEST['ref_venta'];
        $valor = $_REQUEST['valor'];
        $moneda = $_REQUEST['moneda'];
        $estado_pol = $_REQUEST['estado_pol'];
        $firma_cadena = "$llave~$usuario_id~$ref_venta~$valor~$moneda~$estado_pol";
        $firmacreada = md5($firma_cadena); //firma que generaron ustedes
        $firma = $_REQUEST['firma']; //firma que envía nuestro sistema
        $ref_venta = $_REQUEST['ref_venta'];
        $fecha_procesamiento = $_REQUEST['fecha_procesamiento'];
        $codigo_respuesta = $_REQUEST['codigo_respuesta_pol'];
        $estadoTx = "";
        if (strtoupper($firma) == strtoupper($firmacreada)) {//comparacion de las firmas para comprobar que los datos si vienen de Pagosonline

                if ($_REQUEST['estado_pol'] == 6) {
                    $estadoTx = "Transacción fallida";
                } else if ($estado_pol == 6) {
                    $estadoTx = "Transacción rechazada";
                } else if ($_REQUEST['estado_pol'] == 12) {
                    $estadoTx = "Pendiente, Por favor revisar si el débito fue realizado en el Banco";
                } else if ($_REQUEST['estado_pol'] == 4 ) {
                    $estadoTx = "Transacción aprobada";
                    $this->_generar_factura_ghs089sdjkl334();
                } else if ($estado_pol == 7 ) {
                    //transacción en validacion
                    $estadoTx = "Transacción se encuentra en validación";
                } else {
                    $estadoTx = $_REQUEST['mensaje'];
                }
                $this->guardarLog('factura', $estadoTx.' fecha:'.$fecha_procesamiento);
        }
    }
}