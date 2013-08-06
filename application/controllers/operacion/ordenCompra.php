<?php


/**
 * Clase que maneja la migracion de datos al CRM
 */
class OrdenCompra extends CI_Controller {

    /**
     * Constructor de la clase Usuario
     */
    function __construct() {
        parent::__construct();
        $this->load->model('operacion/orden_compra_model');
        $this->load->model('operacion/item_orden_compra_model');
    }

    function index() {
    }

    /**
     * Genera la orden de compra de un proveedor y la envía por correo
     * @return [type] [description]
     */
    function generar_orden(){
        // error_reporting(E_ALL);
        $this->load->model('operacion/item_cotizacion_model');
        $this->load->model('operacion/proveedor_cotizacion_model');
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
            $subtotal += round($subtotalT,2);
            $totalT = ($prov_model->lp_valor * $model['item_cotizacion']->cantidad);
            $total += $totalT;
            $impuestos +=  round(($totalT-$subtotalT), 2);
            $item_orden_compra_model->item = $model['item_cotizacion']->item;
            $item_orden_compra_model->cantidad = $model['item_cotizacion']->cantidad;
            $item_orden_compra_model->precio_unidad = $model['proveedor_cotizacion']->lp_valor;
            $item_orden_compra_model->precio_total = ($item_orden_compra_model->precio_unidad *$item_orden_compra_model->cantidad);
            $items_orden[] = $item_orden_compra_model;
        }
        
        $orden_compra_model = new orden_compra_model();
        $orden_compra_model->fecha_envio = $this->input->post('enviar');
        $orden_compra_model->fecha = date("Y-m-d H:i:s");
        $orden_compra_model->proveedor = $this->input->post('proveedor');
        $orden_compra_model->email_proveedor = $this->input->post('email');
        $orden_compra_model->dir_proveedor = $this->input->post('direccion');
        $orden_compra_model->ciudad_proveedor = $this->input->post('ciudad');
        $orden_compra_model->tel_proveedor = $this->input->post('telefono');
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
    ob_start();
        $this->load->view('operacion/ordencompra/orden_compra_template', $data);
        $html = ob_get_contents();
    ob_end_clean();
    ob_flush();
    $this->phptopdf->phptopdf_html($html, 'resources/ordenCompra/', $nombrePDF);
    $this->load->helper('mail');
    $destinatarios = array();
    // $destinatario = new stdClass();
    // $destinatario->email = $venta->email;
    // $destinatarios[] = $destinatario;
    $destinatario = new stdClass();
    $destinatario->email = "tallerenlinea@laspartes.com.co";
    $destinatarios[] = $destinatario;
    // $destinatario = new stdClass();
    // $destinatario->email = "ventas@laspartes.com.co";
    // $destinatarios[] = $destinatario;

    send_mail($destinatarios, "Orden de compra LasPartes.com - " . strftime("%B %d de %Y"), $html, "", $nombrePDF, 'resources/ordenCompra/');
    echo json_encode(array('status' => true, 'pdf' => $nombrePDF));
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