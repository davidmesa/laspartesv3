<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Clase que en link de pago
 */
class LinkPago extends CI_Controller {

    /**
     * Constructor de la clase OrdenCompra
     */
    function __construct() {
        parent::__construct();
        $this->load->model('operacion/cotizacion_model');
        $this->load->model('operacion/item_cotizacion_model');
        $this->load->model('operacion/proveedor_cotizacion_model');
        $this->load->model('operacion/link_pago_model');
        $this->load->model('operacion/prov_cotizacion_link_pago_model');
        // error_reporting(E_ALL);
    }

    function index() {
    }

    /**
     * muestra los links de pago creados
     * @param  [type] $id_pipeline [description]
     * @param  [type] $id_usuario  [description]
     * @return [type]              [description]
     */
    function mostrar_links($id_pipeline, $id_usuario, $msg){
        if($this->hay_sesion_activa()){
            $data['id_pipeline'] = $id_pipeline;
            $data['id_usuario'] = $id_usuario;
            $cotizacionModel = new cotizacion_model();
            $cotizacionModel->id_pipeline = $id_pipeline;
            $cotizacionModel->dar_por_pipeline();
            $items = $cotizacionModel->dar_items_cotizacion();
            $data['cotizacion'] = $cotizacionModel;
            foreach ($items as $item) {
                $proveedores = $item->dar_proveedores_cotizacion();
                foreach ($proveedores as $proveedor) { 
                    $proveedor->proveedor = $proveedor->dar_proveedor(); 
                }
                $item->proveedores = $proveedores;
            }

            $link_pago_model = new link_pago_model();
            $link_pago_model->id_pipeline = $id_pipeline;
            $data['link_pago_model'] = $link_pago_model->dar_todos_filtros(array('id_pipeline'=> $id_pipeline));

            $data['items'] = $items;
            $data['msg'] = $msg;
            $data['nombrevista'] = 'operacion/linkpago/links/';
            $this->load->view('operacion/linkpago/links/page', $data);
        }else{
            echo 'Debes iniciar sesion como administrador';
        }
    }

    /**
     * Muestra el formulario de guardar links
     * @param  [type] $id_pipeline [description]
     * @param  [type] $id_usuario  [description]
     * @param  [type] $ids         [description]
     * @return [type]              [description]
     */
    function form_link($id_pipeline, $id_usuario, $ids){
        if($this->hay_sesion_activa()){
            $this->load->model('vehiculo_model');
            $this->load->model('generico_model');
            $data['id_pipeline'] = $id_pipeline;
            $data['id_usuario'] = $id_usuario;
            $explodeIds = explode('-', $ids);
            $proveedores_cotizacion = array();
            $titulo = '';
            $precio = 0;
            $iva = 0;
            $margen = 0;
            foreach ($explodeIds as $key => $id) {
                $PC_model = new proveedor_cotizacion_model();
                $PC_model->id = $id;
                $PC_model->dar();
                $PC_model->item = $PC_model->dar_item_cotizacion();
                $proveedores_cotizacion[] = $PC_model;
                $titulo .= $PC_model->item->cantidad.' '.$PC_model->item->item.', ';
                $precioTemp = $PC_model->item->cantidad*($PC_model->lp_valor*(1+($PC_model->item->margen/100)));
                $precio += $precioTemp;
                $iva += $precioTemp - ( $precioTemp/ (1 + ($PC_model->iva/100) ) );
                $baseLP = $PC_model->lp_valor/(1+($PC_model->iva/100))*$PC_model->item->cantidad;
                $margen += $baseLP*($PC_model->item->margen/100);
            }

            $data['precio'] = number_format(round($precio), 0, ',', '.');
            $titulo = substr($titulo, 0, -2);
            $titulo.= ' por $'.$data['precio'];
            $data['titulo'] = $titulo;
            $data['iva'] = number_format(round($iva), 0, ',', '.');
            $data['margen'] = number_format(round($margen), 0, ',', '.');
            $data['proveedores_cotizacion'] = $proveedores_cotizacion;
            $data['servicios'] = $this->generico_model->dar_registros('servicios_categoria');
            $allvehiculos = $this->vehiculo_model->dar_vehiculos();
            foreach ($allvehiculos as $index => $vehiculo) {
                $data['allvehiculos'][$index]->label = $vehiculo->marca . ' ' . $vehiculo->linea;
                $data['allvehiculos'][$index]->value = $vehiculo->id_vehiculo;
            }
            $data['nombrevista'] = 'operacion/linkpago/guardar/';
            $this->load->view('operacion/linkpago/guardar/page', $data);
        }else{
            echo 'Debes iniciar sesion como administrador';
        }
    }

    /**
     * Edita el link de pago
     * @param  [type] $id_oferta id de la oferta
     * @param  [type] $id_link   id del link
     * @return [type]            [description]
     */
    function editar_link($id_oferta, $id_link){
        if($this->hay_sesion_activa()){
            $this->load->model('promocion_model');
            $this->load->model('vehiculo_model');
            $this->load->model('generico_model');
            $link_pago_model = new link_pago_model();
            $link_pago_model->id = $id_link;
            $link_pago_model->dar();
            $data['link_pago'] = $link_pago_model;
            $data['oferta'] = $this->promocion_model->dar_oferta($id_oferta);
            $allvehiculos = $this->vehiculo_model->dar_vehiculos();

            $temp_where[] = 'id_oferta';
            $temp_where[] = $id_oferta;
            $where[] = $temp_where;
            $select[] = 'id_servicios_categoria';
            $id_categorias = $this->generico_model->dar_registros_genericos('establecimientos_ofertas', $select, $where, null, 'id_servicios_categoria');
            $categorias = $this->generico_model->dar_registros('servicios_categoria');
            $temp_categorias = array();
            foreach ($categorias as $categoria):
                $var = new stdClass();
                $var->id = $categoria->id_servicios_categoria;
                $var->nombre = $categoria->nombre;
                $var->encontrado = false;
                foreach ($id_categorias as $id_categoria):
                    if ($id_categoria->id_servicios_categoria == $categoria->id_servicios_categoria) {
                        $var->encontrado = true;
                    }
                endforeach;
                $temp_categorias[] = $var;
            endforeach;
            $temp_where[] = 'id_oferta';
            $temp_where[] = $id_oferta;
            $where[] = $temp_where;
            $temp_select1[] = 'distinct(id_vehiculo)';
            $select1[] = $temp_select1;
            $carros = $this->generico_model->dar_registros_genericos('establecimientos_ofertas', $select1, $where, null, null);

            foreach ($carros as $vehiculos) {
                $autos[] = $this->vehiculo_model->dar_vehiculo($vehiculos->id_vehiculo);
            }
            $data['categorias'] = $temp_categorias;

            //        despliega los vehículos   
            $index = 0;
            foreach ($autos as $vehiculo) {
                $data['autos'][$vehiculo->id_vehiculo]->label = $vehiculo->marca . ' ' . $vehiculo->linea;
                $data['autos'][$vehiculo->id_vehiculo]->value = $vehiculo->id_vehiculo;
                $index++;
            }

            $index = 0;
            foreach ($allvehiculos as $vehiculo) {
                $data['allvehiculos'][$index]->label = $vehiculo->marca . ' ' . $vehiculo->linea;
                $data['allvehiculos'][$index]->value = $vehiculo->id_vehiculo;
                $index++;
            }

            $data['nombrevista'] = 'operacion/linkpago/actualizar/';
            $this->load->view('operacion/linkpago/actualizar/page', $data);
        }else{
            echo 'Debes iniciar sesion como administrador';
        }
    }

    /**
     * Agrega un link de pago y se lo envía al usuario
     */
    function generar_link_pago() {
        if($this->hay_sesion_activa()){
            $id_establecimiento = $this->uri->segment(4);
            $this->load->library('form_validation');
            $reglas = array(
                array(
                    'field' => 'titulo',
                    'label' => 'titulo',
                    'rules' => 'trim|required|xss_clean'
                ), array(
                    'field' => 'precio',
                    'label' => 'precio',
                    'rules' => 'trim|required|numeric|xss_clean'
                ), array(
                    'field' => 'iva',
                    'label' => 'iva',
                    'rules' => 'trim|required|numeric|xss_clean'
                ), array(
                    'field' => 'margen',
                    'label' => 'margen',
                    'rules' => 'trim|required|numeric|xss_clean'
                ), array(
                    'field' => 'vigencia',
                    'label' => 'fecha de vigencia',
                    'rules' => 'trim|required|xss_clean'
                ), array(
                    'field' => 'plazo',
                    'label' => 'plazo de uso',
                    'rules' => 'trim|required|xss_clean'
                ), array(
                    'field' => 'descuento',
                    'label' => 'descuento de promoción',
                    'rules' => 'trim|required|numeric|xss_clean'
                ), array(
                    'field' => 'categoria',
                    'label' => 'categoria',
                    'rules' => 'trim|required|xss_clean'
                ), array(
                    'field' => 'condiciones',
                    'label' => 'condiciones',
                    'rules' => 'trim|xss_clean'
                ),
                array(
                    'field' => 'vehiculo_id',
                    'label' => 'carros',
                    'rules' => 'trim|required|xss_clean'
                ),
                array(
                    'field' => 'categoria_otra',
                    'label' => 'otra categoria',
                    'rules' => 'trim|xss_clean'
                ),
                array(
                    'field' => 'imagen',
                    'label' => 'imagen',
                    'rules' => 'trim|xss_clean'
                ),
                array(
                    'field' => 'id_pipeline',
                    'label' => 'id pipeline',
                    'rules' => 'trim|xss_clean'
                ),
                array(
                    'field' => 'id_usuario',
                    'label' => 'id usuario',
                    'rules' => 'trim|xss_clean'
                )
            );
            $this->form_validation->set_rules($reglas);

            if (!$this->form_validation->run()){
                echo json_encode(array('status' => false, 'msg' => validation_errors()), JSON_HEX_QUOT | JSON_HEX_TAG);
            }else {
                $categorias = array();
                $this->load->model('establecimiento_model');
                $this->load->model('generico_model');
                $this->load->model('usuario_model');
                $id_usuario = $this->input->post('id_usuario', TRUE);
                $id_pipeline = $this->input->post('id_pipeline', TRUE);
                $id_proveedor_cotizacion = explode(',', $this->input->post('id_proveedor_cotizacion', TRUE));
                $vigencia = $this->input->post('vigencia', TRUE);
                $titulo = $this->input->post('titulo', TRUE);
                $condiciones = $this->input->post('condiciones', TRUE);
                $precio = $this->input->post('precio', TRUE);
                $iva = $this->input->post('iva', TRUE);
                $margen = $this->input->post('margen', TRUE);
                $descuento = $this->input->post('descuento', TRUE);
                $plazo = $this->input->post('plazo', TRUE);
                $incluye = $this->input->post('incluye', TRUE);
                $categorias = explode(',', $this->input->post('categoria', TRUE));
                $vehiculos = explode(',', $this->input->post('vehiculo_id', TRUE));
                $otra_categoria = $this->input->post('categoria_otra', TRUE);
                $imagen = $this->input->post('imagen', TRUE);
                if ($otra_categoria) {
                    $tempCat[] = 'nombre';
                    $tempCat[] = $otra_categoria;
                    $cat[] = $tempCat;
                    $id_cat = $this->generico_model->agreagar_registros_genericos('servicios_categoria', $cat);
                    $categorias[] = $id_cat;
                }

                $this->load->library('upload');
                $upload_path = 'resources/images/promociones/';
                $config = array(
                    'upload_path' => $upload_path,
                    'allowed_types' => 'gif|jpg|png',
                    'max_size' => '10000'
                );
                $this->upload->initialize($config);

                if ($this->upload->do_upload('imagen')) {
                    $img = $this->upload->data();
                    $id = $this->establecimiento_model->agregar_oferta($titulo, $precio, $condiciones, $incluye, $id_establecimiento, $categorias, $vehiculos, $vigencia, '', $iva, $margen, $descuento, $plazo, $upload_path . $img['file_name']);
                    $url = 'promociones/' . $id . '-' . preg_replace(array('/[^a-z0-9-]/i', '/[ ]{2,}/', '/[ ]/'), array(' ', ' ', '-'), $titulo);
                } else {
                    if (!$imagen) {
                        $id = $this->establecimiento_model->agregar_oferta($titulo, $precio, $condiciones, $incluye, $id_establecimiento, $categorias, $vehiculos, $vigencia, '', $iva, $margen, $descuento, $plazo);
                        $url = 'promociones/' . $id . '-' . preg_replace(array('/[^a-z0-9-]/i', '/[ ]{2,}/', '/[ ]/'), array(' ', ' ', '-'), $titulo);
                    } else {
                        $id = $this->establecimiento_model->agregar_oferta($titulo, $precio, $condiciones, $incluye, $id_establecimiento, $categorias, $vehiculos, $vigencia, '', $iva, $margen, $descuento, $plazo);
                        $url = 'promociones/' . $id . '-' . preg_replace(array('/[^a-z0-9-]/i', '/[ ]{2,}/', '/[ ]/'), array(' ', ' ', '-'), $titulo);
                    }
                }

                $link_pago_model = new link_pago_model();
                $link_pago_model->id_pipeline = $id_pipeline;
                $link_pago_model->id_usuario = $id_usuario;
                $link_pago_model->id_oferta = $id;
                $link_pago_model->url = $url;
                $link_pago_model->insertar();

                foreach ($id_proveedor_cotizacion as $value) {
                    $prov_cotizacion_link_pago_model = new prov_cotizacion_link_pago_model();
                    $prov_cotizacion_link_pago_model->id_link_pago = $link_pago_model->id;
                    $prov_cotizacion_link_pago_model->id_proveedor_cotizacion = $value;
                    $prov_cotizacion_link_pago_model->insertar();
                }

                $data['link_pago'] = $link_pago_model;
                $data['incluye'] = $incluye;
                $data['titulo'] = $titulo;
                $data['vehiculos'] = $vehiculos;
                $data['usuario'] = $this->usuario_model->dar_usuario($id_usuario);
                ob_start();
                    $this->load->view('emails/link_pago_view', $data);
                    $html = ob_get_contents();
                ob_end_clean();
                ob_flush();

                $destinatarios = array();
                // $destinatario = new stdClass();
                // $destinatario->email = $orden_compra_model->email_proveedor;
                // $destinatarios[] = $destinatario;
                $destinatario = new stdClass();
                $destinatario->email = "tallerenlinea@laspartes.com.co";
                $destinatarios[] = $destinatario;
                $this->load->helper('mail');
                send_mail($destinatarios, "Link de pago - LasPartes.com", $html, "");
                echo json_encode(array('status' => true));
            }
        }else{
        echo json_encode(array('status' => false, 'msg' => 'Debes iniciar sesión como administrador'));
        }
    }

    /**
     * Agrega un link de pago y se lo envía al usuario
     */
    function actualizar_link_pago() {
        if($this->hay_sesion_activa()){
            $id_establecimiento = $this->uri->segment(4);
            $this->load->library('form_validation');
            $reglas = array(
                array(
                    'field' => 'titulo',
                    'label' => 'titulo',
                    'rules' => 'trim|required|xss_clean'
                ), array(
                    'field' => 'precio',
                    'label' => 'precio',
                    'rules' => 'trim|required|numeric|xss_clean'
                ), array(
                    'field' => 'iva',
                    'label' => 'iva',
                    'rules' => 'trim|required|numeric|xss_clean'
                ), array(
                    'field' => 'margen',
                    'label' => 'margen',
                    'rules' => 'trim|required|numeric|xss_clean'
                ), array(
                    'field' => 'vigencia',
                    'label' => 'fecha de vigencia',
                    'rules' => 'trim|required|xss_clean'
                ), array(
                    'field' => 'plazo',
                    'label' => 'plazo de uso',
                    'rules' => 'trim|required|xss_clean'
                ), array(
                    'field' => 'descuento',
                    'label' => 'descuento de promoción',
                    'rules' => 'trim|required|numeric|xss_clean'
                ), array(
                    'field' => 'categoria',
                    'label' => 'categoria',
                    'rules' => 'trim|required|xss_clean'
                ), array(
                    'field' => 'condiciones',
                    'label' => 'condiciones',
                    'rules' => 'trim|xss_clean'
                ),
                array(
                    'field' => 'vehiculo_id',
                    'label' => 'carros',
                    'rules' => 'trim|required|xss_clean'
                ),
                array(
                    'field' => 'categoria_otra',
                    'label' => 'otra categoria',
                    'rules' => 'trim|xss_clean'
                ),
                array(
                    'field' => 'imagen',
                    'label' => 'imagen',
                    'rules' => 'trim|xss_clean'
                ),
                array(
                    'field' => 'id_pipeline',
                    'label' => 'id pipeline',
                    'rules' => 'trim|xss_clean'
                ),
                array(
                    'field' => 'id_usuario',
                    'label' => 'id usuario',
                    'rules' => 'trim|xss_clean'
                )
            );
            $this->form_validation->set_rules($reglas);

            if (!$this->form_validation->run()){
                echo json_encode(array('status' => false, 'msg' => validation_errors()), JSON_HEX_QUOT | JSON_HEX_TAG);
            }else {
                $categorias = array();
                $this->load->model('establecimiento_model');
                $this->load->model('generico_model');
                $this->load->model('usuario_model');
                $id_usuario = $this->input->post('id_usuario', TRUE);
                $id_oferta = $this->input->post('id_oferta', TRUE);
                $vigencia = $this->input->post('vigencia', TRUE);
                $titulo = $this->input->post('titulo', TRUE);
                $condiciones = $this->input->post('condiciones', TRUE);
                $precio = $this->input->post('precio', TRUE);
                $iva = $this->input->post('iva', TRUE);
                $margen = $this->input->post('margen', TRUE);
                $descuento = $this->input->post('descuento', TRUE);
                $plazo = $this->input->post('plazo', TRUE);
                $incluye = $this->input->post('incluye', TRUE);
                $categorias = explode(',', $this->input->post('categoria', TRUE));
                $vehiculos = explode(',', $this->input->post('vehiculo_id', TRUE));
                $otra_categoria = $this->input->post('categoria_otra', TRUE);
                $imagen = $this->input->post('imagen', TRUE);
                if ($otra_categoria) {
                    $tempCat[] = 'nombre';
                    $tempCat[] = $otra_categoria;
                    $cat[] = $tempCat;
                    $id_cat = $this->generico_model->agreagar_registros_genericos('servicios_categoria', $cat);
                    $categorias[] = $id_cat;
                }

                $this->load->library('upload');
                $upload_path = 'resources/images/promociones/';
                $config = array(
                    'upload_path' => $upload_path,
                    'allowed_types' => 'gif|jpg|png',
                    'max_size' => '10000'
                );
                $this->upload->initialize($config);

                if ($this->upload->do_upload('imagen')) {
                    $img = $this->upload->data();
                    $this->establecimiento_model->actualizar_oferta($titulo, $precio, $condiciones, $incluye, $categorias, $id_oferta, $id_establecimiento, $vehiculos, $vigencia, '', $iva, $margen, $descuento, $plazo, $upload_path . $img['file_name']);
                    $url = 'promociones/' . $id_oferta . '-' . preg_replace(array('/[^a-z0-9-]/i', '/[ ]{2,}/', '/[ ]/'), array(' ', ' ', '-'), $titulo);
                } else {
                    if (!$imagen) {
                        $this->establecimiento_model->actualizar_oferta($titulo, $precio, $condiciones, $incluye, $categorias, $id_oferta, $id_establecimiento, $vehiculos, $vigencia, '', $iva, $margen, $descuento, $plazo);
                        $url = 'promociones/' . $id_oferta . '-' . preg_replace(array('/[^a-z0-9-]/i', '/[ ]{2,}/', '/[ ]/'), array(' ', ' ', '-'), $titulo);
                    } else {
                        $this->establecimiento_model->actualizar_oferta($titulo, $precio, $condiciones, $incluye, $categorias, $id_oferta, $id_establecimiento, $vehiculos, $vigencia, '', $iva, $margen, $descuento, $plazo);
                        $url = 'promociones/' . $id_oferta . '-' . preg_replace(array('/[^a-z0-9-]/i', '/[ ]{2,}/', '/[ ]/'), array(' ', ' ', '-'), $titulo);
                    }
                }

                $link_pago_model = new link_pago_model();
                $link_pago_model->id= $this->input->post('id_link_pago',true);
                $link_pago_model->dar();
                $link_pago_model->url= $url;
                $link_pago_model->actualizar();

                $data['link_pago'] = $link_pago_model;
                $data['incluye'] = $incluye;
                $data['titulo'] = $titulo;
                $data['usuario'] = $this->usuario_model->dar_usuario($id_usuario);
                ob_start();
                    $this->load->view('emails/link_pago_view', $data);
                    $html = ob_get_contents();
                ob_end_clean();
                ob_flush();

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
}