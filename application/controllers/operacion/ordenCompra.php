<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Clase que maneja las ordenes de compra
 */
class OrdenCompra extends CI_Controller {

    /**
     * Constructor de la clase OrdenCompra
     */
    function __construct() {
        parent::__construct();
        $this->load->model('operacion/orden_compra_model');
        $this->load->model('operacion/item_orden_compra_model');
        // error_reporting(E_ALL);
    }

    function index() {
    }

    /**
     * Genera la orden de compra de un proveedor y la envía por correo
     * @return [type] [description]
     */
    function generar_orden(){
        if($this->hay_sesion_activa()){
            $this->load->library('form_validation');
            $reglas = array(
                array(
                    'field' => 'id-proveedores-cot',
                    'label' => 'id proveedor cotizacion',
                    'rules' => 'trim|xss_clean|required'
                ),
                array(
                    'field' => 'proveedor',
                    'label' => 'proveedor',
                    'rules' => 'trim|required|xss_clean'
                ),
                array(
                    'field' => 'email',
                    'label' => 'email',
                    'rules' => 'trim|xss_clean|required|valid_email'
                ),
                array(
                    'field' => 'direccion',
                    'label' => 'direccion',
                    'rules' => 'trim|xss_clean'
                ),
                array(
                    'field' => 'ciudad',
                    'label' => 'ciudad',
                    'rules' => 'trim|xss_clean'
                ),
                array(
                    'field' => 'telefono',
                    'label' => 'telefono',
                    'rules' => 'trim|xss_clean'
                ),
                array(
                    'field' => 'id_proveedor',
                    'label' => 'id del proveedor',
                    'rules' => 'trim|xss_clean|required'
                ),
                array(
                    'field' => 'enviar',
                    'label' => 'enviar',
                    'rules' => 'trim|xss_clean'
                ),
                array(
                    'field' => 'id_cotizacion',
                    'label' => 'id de la cotización',
                    'rules' => 'trim|xss_clean|required'
                )
            );
            $this->form_validation->set_rules($reglas);

            if(!$this->form_validation->run()){
                $this->form_validation->set_error_delimiters('', '');
                echo json_encode(array('status' => false, 'msg' => validation_errors()));
            }else{
                $this->load->model('operacion/item_cotizacion_model');
                $this->load->model('operacion/proveedor_cotizacion_model');
                $this->load->model('operacion/proveedor_model');
                $id_provedores_cot = json_decode($this->input->post('id-proveedores-cot'), true);
                $proveedor_item_cotizacion = array();
                $subtotal = 0;
                $total = 0;
                $impuestos = 0;
                $items_orden = array();
                foreach ($id_provedores_cot as $id) {
                    $item_orden_compra_model = new item_orden_compra_model();
                    $prov_model = new proveedor_cotizacion_model();
                    $prov_model->id = $id;
                    $prov_model->dar();
                    $model['proveedor_cotizacion'] = $prov_model;
                    $model['item_cotizacion'] = $prov_model->dar_item_cotizacion();
                    $proveedor_item_cotizacion[] = $model;
                    $subtotalT = ($prov_model->lp_valor*$model['item_cotizacion']->cantidad)/(1+($prov_model->iva/100)); 
                    $subtotal += round($subtotalT, 0);
                    $totalT = ($prov_model->lp_valor * $model['item_cotizacion']->cantidad);
                    $total += $totalT;
                    $impuestos +=  round(($totalT-$subtotalT), 0);
                    $item_orden_compra_model->item = $model['item_cotizacion']->item;
                    $item_orden_compra_model->cantidad = $model['item_cotizacion']->cantidad;
                    $item_orden_compra_model->precio_unidad = round($model['proveedor_cotizacion']->lp_valor/(1+($model['proveedor_cotizacion']->iva/100)), 0);
                    $item_orden_compra_model->precio_total = ($item_orden_compra_model->precio_unidad *$item_orden_compra_model->cantidad);
                    $items_orden[] = $item_orden_compra_model;
                }
                
                $proveedor_model = new proveedor_model();
                $proveedor_model->proveedor = $this->input->post('proveedor');
                $proveedor_model->email = $this->input->post('email');
                $proveedor_model->direccion = $this->input->post('direccion');
                $proveedor_model->ciudad = $this->input->post('ciudad');
                $proveedor_model->telefono = $this->input->post('telefono');
                $proveedor_model->id = $this->input->post('id_proveedor');
                if($this->input->post('modificado')){
                    $proveedor_model->actualizar();
                }
                $orden_compra_model = new orden_compra_model();
                $orden_compra_model->fecha_envio = $this->input->post('enviar');
                $orden_compra_model->fecha = date("Y-m-d H:i:s");
                $orden_compra_model->observacion = $this->input->post('observacion');
                $orden_compra_model->id_cotizacion = $this->input->post('id_cotizacion');
                $orden_compra_model->id_proveedor = $proveedor_model->id;
                $orden_compra_model->proveedor = $proveedor_model->proveedor;
                $orden_compra_model->email_proveedor = $proveedor_model->email;
                $orden_compra_model->dir_proveedor = $proveedor_model->direccion;
                $orden_compra_model->ciudad_proveedor = $proveedor_model->ciudad;
                $orden_compra_model->tel_proveedor = $proveedor_model->telefono;
                $orden_compra_model->subtotal = $subtotal;
                $orden_compra_model->impuestos_ventas = $impuestos;
                $orden_compra_model->total = $total;
                $orden_compra_model->insertar();
                foreach ($items_orden as $key => $item) {
                    $item->id_orden_compra = $orden_compra_model->id;
                    $item->insertar();
                    $items_orden[$key] = $item;
                }
                $data['orden_compra_model'] = $orden_compra_model;
                $data['item_orden_compra_model'] = $items_orden;
                setlocale(LC_ALL, 'es_ES');

            $this->load->library('phptopdf');
            $nombre_prov = $this->sanitize($data['orden_compra_model']->proveedor);
            $nombrePDF = $data['orden_compra_model']->id.'-'.$nombre_prov.'.pdf';
            $this->orden_compra_model->actualizar_filtros($data['orden_compra_model']->id, array('url'=>$nombrePDF));
            ob_start();
                $this->load->view('operacion/ordencompra/orden_compra_template', $data);
                $html = ob_get_contents();
            ob_end_clean();
            ob_flush();
            $this->phptopdf->phptopdf_html($html, 'resources/ordenCompra/', $nombrePDF);
            $this->load->helper('mail');
            $destinatarios = array();
            $destinatario = new stdClass();
            $destinatario->email = $proveedor_model->email;
            $destinatarios[] = $destinatario;
            $destinatario = new stdClass();
            $destinatario->email = "tallerenlinea@laspartes.com.co";
            $destinatarios[] = $destinatario;
            $destinatario = new stdClass();
            $destinatario->email = "ventas@laspartes.com.co";
            $destinatarios[] = $destinatario;
            // $destinatario = new stdClass();
            // $destinatario->email = "direcciondesarrollo@laspartes.com.co";
            // $destinatarios[] = $destinatario;

            send_mail($destinatarios, "Orden de compra ".str_pad($data['orden_compra_model']->id, 4, '0', STR_PAD_LEFT)." - LasPartes.com - " . strftime("%B %d de %Y"), $html, "", $nombrePDF, 'resources/ordenCompra/');
            echo json_encode(array('status' => true, 'pdf' => $nombrePDF, 'id' => $data['orden_compra_model']->id));
            }
        }else{
            echo json_encode(array('status' => false, 'msg' => 'Debes iniciar sesión como administrador'));
        }
    }

    /**
     * Anula una orden de compra
     * @return [type] [description]
     */
    function anular(){
        if($this->hay_sesion_activa()){
            $this->load->library('form_validation');
            $reglas = array(
                array(
                    'field' => 'id',
                    'label' => 'id orden de compra',
                    'rules' => 'trim|xss_clean|required'
                )
            );
            $this->form_validation->set_rules($reglas);

            if(!$this->form_validation->run()){
                $this->form_validation->set_error_delimiters('', '');
                echo json_encode(array('status' => false, 'msg' => validation_errors()));
            }else{
                $orden_compra_model = new orden_compra_model();
                $orden_compra_model->id = $this->input->post('id');
                $orden_compra_model->dar();
                $data['orden_compra'] = $orden_compra_model;
                $nueva_url = explode('.pdf', $orden_compra_model->url);
                rename('resources/ordenCompra/'.$orden_compra_model->url, 'resources/ordenCompra/'.$nueva_url[0].'-anulado.pdf');
                $this->orden_compra_model->actualizar_filtros($orden_compra_model->id, array('anulado'=>1, 'url' => $nueva_url[0].'-anulado.pdf'));
                ob_start();
                    $this->load->view('emails/anular_orden_compra_view', $data);
                    $html = ob_get_contents();
                ob_end_clean();
                ob_flush();
                $destinatarios = array();
                $destinatario = new stdClass();
                $destinatario->email = $orden_compra_model->email_proveedor;
                $destinatarios[] = $destinatario;
                $destinatario = new stdClass();
                $destinatario->email = "tallerenlinea@laspartes.com.co";
                $destinatarios[] = $destinatario;
                $destinatario = new stdClass();
                $destinatario->email = "ventas@laspartes.com.co";
                $destinatarios[] = $destinatario;
                $this->load->helper('mail');
                send_mail($destinatarios, "Orden de compra ".str_pad($orden_compra_model->id, 4, '0', STR_PAD_LEFT)." anulado LasPartes.com - " . strftime("%B %d de %Y"), $html, "");
                echo json_encode(array('status' => true));
            }
        }else{
            echo json_encode(array('status' => false, 'msg' => 'Debes iniciar sesión como administrador'));
        }
    }

     //Valida si existe una sesion activa
    //en caso de que la sesión este activa, retorna true, de lo contrario false
    function hay_sesion_activa(){
        $sesion = $this->session->userdata('esta_registrado');
        $tipo = $this->session->userdata('tipo');
        if( $sesion == true && $tipo == 10) {
            return true;
        }else {
            return false;
        }
    }

/**
     * Función que genera un valor alfanumérico para el valor de la referencia de la factura
     * @param type $length
     * @return String código único 
     */
function _getUniqueCode($length = "") {
    $code = md5(uniqid(rand(), true));
    if ($length != "")
        return substr($code, 0, $length);
    else
        return $code;
}

/**
 * Function: sanitize
 * Returns a sanitized string, typically for URLs.
 *
 * Parameters:
 *     $string - The string to sanitize.
 *     $force_lowercase - Force the string to lowercase?
 *     $anal - If set to *true*, will remove all non-alphanumeric characters.
 */
function sanitize($string, $force_lowercase = true, $anal = false) {
    $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
                   "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
                   "â€”", "â€“", ",", "<", ".", ">", "/", "?");
    $clean = trim(str_replace($strip, "", strip_tags($string)));
    $clean = preg_replace('/\s+/', "-", $clean);
    $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean ;
    return ($force_lowercase) ?
        (function_exists('mb_strtolower')) ?
            mb_strtolower($clean, 'UTF-8') :
            strtolower($clean) :
        $clean;
}

}