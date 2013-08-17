<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Clase que maneja la migracion de datos al CRM
 */
class Cotizaciones extends CI_Controller {

    /**
     * Constructor de la clase cotizaciones
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('operacion/proveedor_cotizacion_model');
        $this->load->model('operacion/cotizacion_model');
        $this->load->model('operacion/item_cotizacion_model');
        $this->load->model('operacion/proveedor_model');
        // error_reporting(E_ALL);
    }

    function index() {

    }

    /**
     * Muestra el iFrame para realizar cotizaciones
     * @return [type] [description]
     */
    function mostrar_cotizaciones($id_pipeline, $id_usuario, $msj = ''){
        if($this->hay_sesion_activa()){
            $this->load->model('operacion/orden_compra_model');
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
            $data['items'] = $items;
            $filtros = array('id_cotizacion'=>$cotizacionModel->id);
            $data['ordenes_compras'] = $this->orden_compra_model->dar_todos_por_filtros($filtros);
            $proveedores = $this->proveedor_model->dar_todos();
            $data['all_proveedores'];
            $index = 0;
            foreach ($proveedores as $proveedor) {
                $data['all_proveedores'][$index]->label = $proveedor->proveedor;
                $data['all_proveedores'][$index]->email = $proveedor->email;
                $data['all_proveedores'][$index]->ciudad = $proveedor->ciudad;
                $data['all_proveedores'][$index]->direccion = $proveedor->direccion;
                $data['all_proveedores'][$index]->telefono = $proveedor->telefono;
                $index++;
            }
            $data['msj'] = $msj;
            $data['nombrevista'] = 'operacion/cotizacion/';
            $this->load->view('operacion/cotizacion/page', $data);
        }else{
            echo 'Debes iniciar sesion como administrador';
        }
    }

    /**
     * guarda la información de la cotización
     * @return [type] [description]
     */
    function guardar(){
        if($this->hay_sesion_activa()){
            $this->load->library('form_validation');
            $reglas = array(
                array(
                    'field' => 'id_usuario',
                    'label' => 'id usuario',
                    'rules' => 'trim|xss_clean'
                ),
                array(
                    'field' => 'id_pipeline',
                    'label' => 'id pipeline',
                    'rules' => 'trim|required|xss_clean'
                ),
                array(
                    'field' => 'items',
                    'label' => 'información',
                    'rules' => 'trim|xss_clean'
                ),
                array(
                    'field' => 'retenciones',
                    'label' => 'retenciones',
                    'rules' => 'trim|xss_clean'
                )
            );
            $this->form_validation->set_rules($reglas);

            if(!$this->form_validation->run()){
                $this->form_validation->set_error_delimiters('', '');
                echo json_encode(array('status' => false, 'msg' => validation_errors()));
            }else{
                $this->load->model('operacion/proveedor_model');
                $dataTemp = json_decode($this->input->post('items'), true);
                $id_usuario = $this->input->post('id_usuario');
                $id_pipeline = $this->input->post('id_pipeline');
                $retenciones = json_decode($this->input->post('retenciones'), true);
                $itemsCot = array();
                $proveedoresCot = array();
                foreach ($dataTemp as $data) {
                    $cantidad = $data[cantidad];
                    $elegido = $data[elegido];
                    $item = $data[item];
                    $margen = $data[margen];
                    $id_item = $data[id_item];
                    $Tcosto;
                    $Tlp_iva;
                    $Tlp_valor;
                    $Tcliente_iva;
                    $Tcliente_precio;
                    $Tganancia;
                    foreach ($data[proveedores] as $provedor => $ops){ 
                        $proveedorCotizacionModel = new proveedor_cotizacion_model();
                        if($ops[id_proveedor_cotizacion]){
                            $proveedorCotizacionModel->id = $ops[id_proveedor_cotizacion];
                            $proveedorCotizacionModel->dar();
                        }
                        $proveedorModel = new proveedor_model();
                        $filtros = array('email' => $ops[email]);
                        $proveedorModel->dar_por_filtros($filtros);//falta validar que el nombre no se repita
                        if(!$proveedorModel->id){//si no existe debe agregar el proveedor
                            $proveedorModel->email = $ops[email];
                            $proveedorModel->proveedor = $provedor;
                            $proveedorModel->insertar();
                        }

                        $proveedorCotizacionModel->id_proveedor = $proveedorModel->id;
                        $proveedorCotizacionModel->lp_valor = $ops[valorLP];
                        $proveedorCotizacionModel->iva = $ops[iva];
                        $proveedorCotizacionModel->nota = $ops[nota];
                        $proveedorCotizacionModel->elegido = $ops[elegido];
                        $proveedoresCot[$item][$provedor] = $proveedorCotizacionModel;

                        if($ops[elegido] == true && isset($ops[elegido])){
                            $lp_valor = $ops[valorLP];
                            $ivaTmp = $ops[iva];
                            $costo = $lp_valor/(1+($ivaTmp/100));
                            $ivaLP = $costo*($ivaTmp/100);
                            $valor_antes_iva = $costo*$cantidad*(1+($margen/100));
                            $cliente_iva = $valor_antes_iva*($ivaTmp/100);
                            $cliente_precio = $valor_antes_iva + $cliente_iva;
                            $ganancia = $valor_antes_iva-$costo;
                            // echo  'ITEM: '.$item.' MARGEN: '.$margen.' CANTIDAD: '.$cantidad.' VALORLP: '.$lp_valor. ' IVA: '.   $ivaTmp. ' COSTO: '.$costo. ' IVALP: '.$ivaLP. ' VALORANTES: '.$valor_antes_iva . ' PRECIOCLIENTE '.$cliente_precio.'<br/>------<br/>';

                            $Tcosto += $costo*$cantidad;
                            $Tlp_iva += $ivaLP*$cantidad;
                            $Tlp_valor += $lp_valor*$cantidad;
                            $Tcliente_iva += $cliente_iva*$cantidad;
                            $Tcliente_precio += $cliente_precio*$cantidad;
                            $Tganancia += $ganancia*$cantidad;
                            // echo  'COSTO: '.$Tcosto. ' LPIVA: '.   $Tlp_iva. ' LPVALOR: '.$Tlp_valor. ' IVACLIENTE: '.$Tcliente_iva. ' PRECIO: '.$Tcliente_precio . ' GANANCIA '.$Tganancia.'</br>';
                        }
                        
                    }
                    
                    $itemCotizacionModel = new item_cotizacion_model();
                    
                    if($id_item){
                        $itemCotizacionModel->id = $id_item;
                        $itemCotizacionModel->dar();
                    }
                    $itemCotizacionModel->item = $item;
                    $itemCotizacionModel->cantidad = $cantidad;
                    $itemCotizacionModel->margen = $margen;
                    $itemsCot[] = $itemCotizacionModel;
                }
                // echo  'COSTO: '.$Tcosto. ' LPIVA: '.   $Tlp_iva. ' LPVALOR: '.$Tlp_valor. ' IVACLIENTE: '.$Tcliente_iva. ' PRECIO: '.$Tcliente_precio . ' GANANCIA '.$Tganancia.'</br>';
                $cotizacionModel = new cotizacion_model();
                $cotizacionModel->id_pipeline = $id_pipeline;
                $cotizacionModel->dar_por_pipeline();
                $cotizacionModel->id_usuario = $id_usuario;
                $cotizacionModel->costo = $Tcosto;
                $cotizacionModel->lp_iva = $Tlp_iva;
                $cotizacionModel->lp_valor = $Tlp_valor;
                $cotizacionModel->cliente_iva = $Tcliente_iva;
                $cotizacionModel->cliente_precio = $Tcliente_precio;
                $cotizacionModel->cree = $retenciones[cree];
                $cotizacionModel->ica = $retenciones[ica];
                $cotizacionModel->retefuente = $retenciones[retefuente];
                $cotizacionModel->ganancia = $Tganancia;
                if($cotizacionModel->id)
                    $cotizacionModel->actualizar();
                else{    
                    $cotizacionModel->insertar();
                }foreach ($itemsCot as $item) {
                    if($item->id){
                        $item->actualizar();
                    }else{
                        $item->id_cotizacion = $cotizacionModel->id;
                        $item->insertar();
                    }    
                    foreach ($proveedoresCot[$item->item] as $proveedor) {
                        if($proveedor->id){
                            $proveedor->actualizar();
                        }else{   
                            $proveedor->id_item_cotizacion = $item->id; 
                            $proveedor->insertar();
                        }
                    }
                }
                echo json_encode(array('status' => true));
            }
        }else{
            echo json_encode(array('status' => false, 'msg' => 'Debes iniciar sesión como administrador'));
        }
    }

    /**
     * Existe proveedor
     * @return bool
     */
    function existe_proveedor(){
        $this->load->library('form_validation');
        $reglas = array(
            array(
                'field' => 'email',
                'label' => 'email',
                'rules' => 'trim|required|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);
        if (!$this->form_validation->run())
            echo 'false';
        else {
            $email = $this->input->post('email', TRUE);
            $proveedor_model = new proveedor_model();
            $proveedor_model->dar_por_filtros(array('email'=>$email));
            if ($proveedor_model->id)
                echo json_encode(array('status' => true, 'msg' => json_encode($proveedor_model)));
            else
                echo json_encode(array('status' => false));
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


    function crearProveedores(){
        $this->db->select('establecimientos.*, zonas.ciudad');
        $this->db->from('establecimientos');
        $this->db->join('zonas', 'establecimientos.id_zona = zonas.id_zona');
        $q = $this->db->get();

        foreach ($q->result() as $obj) {
            // var_dump($obj);
            $this->db->set('proveedor', $obj->nombre);
            $this->db->set('email', $obj->email);
            $this->db->set('direccion', $obj->direccion);
            $this->db->set('ciudad', $obj->ciudad);
            $this->db->set('telefono', $obj->telefonos);
            $this->db->insert('op_proveedores');
        }
    }

}