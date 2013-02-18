<?php

/**
 * Clase que maneja los establecimientos
 */
class Ventas extends CI_Controller {

    /**
     * Constructor de la clase Establecimiento
     */
    function __construct() {
        parent::__construct();
        $esta_registrado = $this->session->userdata('esta_registrado');
        if (!isset($esta_registrado) || !$esta_registrado || $this->session->userdata('tipo') != 20)
            redirect(base_url() . 'admin-establecimiento/inicio', 'refresh');
    }

    /**
     * Da la lista de establecimientos
     * @return array $establecimientos
     */
    function _ver_establecimientos() {
        $id_usuario = $this->session->userdata('id_usuario');
        $this->load->model('establecimiento_model');
        $data['establecimientos'] = $this->establecimiento_model->dar_establecimientos_usuario($id_usuario);
        return $data;
    }

    /**
     * Muestra las ventas que ha realizado el establecimiento
     */
    function index() {
        $data = $this->_ver_establecimientos();
        $this->load->view('admin-establecimiento/ventas/mis_ventas_lista_view', $data);
    }

    /**
     * Da detalles de las ventas de un establecimiento
     * @param int $id_establecimiento
     * @return array con $establecimiento y $zonas
     */
    function _ver_establecimiento_ventas($id_establecimiento) {
        $this->load->model('establecimiento_model');
        $this->load->model('usuario_model');
        $data['carritos_compras'] = $this->establecimiento_model->dar_carritos_compras_establecimiento($id_establecimiento);
        $data['carritos_compras_autopartes'] = $this->establecimiento_model->dar_carritos_compras_establecimiento($id_establecimiento);
        $data['establecimiento'] = $this->establecimiento_model->dar_establecimiento($id_establecimiento);
        return $data;
    }

    /**
     * Verifica si un usuario puede tomar acción en el establecimiento
     * @param int $id_establecimiento
     * @return bool $tiene_permiso
     */
    function _verificar_usuario_permiso_establecimiento($id_establecimiento) {
        $this->load->model('establecimiento_model');
        $resultado = $this->establecimiento_model->esta_asignado_usuario_establecimiento($this->session->userdata('id_usuario'), $id_establecimiento);
        if ($resultado == 1)
            return TRUE;
        else
            return FALSE;
    }

    /**
     * Muestra las ventas de un establecimiento
     */
    function ver_ventas() {
        $id_establecimiento = $this->uri->segment(4);
        if ($this->_verificar_usuario_permiso_establecimiento($id_establecimiento)) {
            $data = $this->_ver_establecimiento_ventas($id_establecimiento);
            $this->load->view('admin-establecimiento/ventas/mis_ventas_detalle_view', $data);
        }
    }

    function carrito_realizado_ajax() {
        $id_carrito = $this->input->get_post('id_carrito', TRUE);
        $estado = $this->input->get_post('estado', TRUE);
        $this->load->model('usuario_model');
        $this->usuario_model->carrito_realizado($id_carrito, $estado);

        //envia el correo con la venta realizada a taller en linea
        $this->_enviar_correo_confirmacion($id_carrito);
    }

    /**
     * Envia un correo de comfirmación de que la venta se realizó
     * @param type $id_carrito 
     */
    function _enviar_correo_confirmacion($id_carrito) { 
        $this->load->helper('mail');
        $this->load->helper('date');
        $this->load->model('establecimiento_model');
        $carrito = $this->establecimiento_model->dar_carrito_compras_info($id_carrito);
        if (strlen($carrito->nombre) > 0 && strlen($carrito->cantidad) > 0) {
            $mensajeHTML = '
                            Venta entregada y realizada
                            <br /><br />
                            Detalles de la venta: <br/>
                            <strong>Compra:  </strong> # ' . $carrito->carrito . '<br/>
                            <strong>Estado: </strong>' . $carrito->estado . '<br/>
                            <strong>No. Factura: </strong>' . $carrito->factura . '<br/>
                            <strong>Fecha de entrega: </strong>' . strftime("%B %d de %Y") . '<br/>
                            <strong>Cliente: </strong>' . $carrito->usuario . '<br/>
                            <strong>Total: </strong>' . $carrito->carritoTotal . '<br/>
                            Cordialmente,<br />
                            -------------------------------------------------------<br />
                            Servicio al cliente<br />
                            <a style="text-decoration: none; color: red;" href="' . base_url() . '">Laspartes.com</a> - Todo para su vehículo                
';
        } else {

            $mensajeHTML = '
                            Venta entregada y realizada
                            <br /><br />
                            Detalles de la venta: <br/>
                            <strong>Compra:  </strong> # ' . $carrito->carrito . '<br/>
                            <strong>Estado: </strong>' . $carrito->estado . '<br/>
                            <strong>No. Factura: </strong>' . $carrito->factura . '<br/>
                            <strong>Fecha de entrega: </strong>' . strftime("%B %d de %Y") . '<br/>
                            <strong>Cliente: </strong>' . $carrito->usuario . '<br/>
                            <strong>Total: </strong>$' . number_format($carrito->carritoTotal, 0, ',', '.') . '<br/>
                            Cordialmente,<br />
                            -------------------------------------------------------<br />
                            Servicio al cliente<br />
                            <a style="text-decoration: none; color: red;" href="' . base_url() . '">Laspartes.com</a> - Todo para su vehículo                
';
        }



        $destinatario = new stdClass();
        $destinatario->email = 'tallerenlinea@laspartes.com.co';
//        $destinatario->email = 'cabarique.luis@gmail.com'; 
        $destinatarios[] = $destinatario;
        send_mail($destinatarios, "[LasPartes.com] Compra entregada", $mensajeHTML, "", $fileName);
    }

}