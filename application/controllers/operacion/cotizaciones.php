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
         //error_reporting(E_ALL);
    }

    function index() {
        $this->load->library('crm');
        $uID_usuario = $this->crm->dar_id_usuario_pipeline_REST('1616e167-b243-3b55-2a06-52095df805fc');
        $vehiculos = $this->crm->prueba($uID_usuario);
        echo $uID_usuario.'<br/>';
        $objEncode = json_encode($vehiculos);
        echo '<script>console.log('.$objEncode.')</script>';
    }
    /**
     * Muestra el iFrame para realizar cotizaciones
     * @return [type] [description]
     */
    function mostrar_cotizaciones($id_pipeline, $id_usuario, $msj = ''){
        if($this->hay_sesion_activa()){
            $this->load->model('usuario_model');
            $this->load->model('operacion/orden_compra_model');
            $data['id_pipeline'] = $id_pipeline;
            $data['id_usuario'] = $id_usuario;
            $data['usuario'] = $this->usuario_model->dar_usuario($id_usuario);
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

            //Comunicación con librería de CRM para obtener los vehículos asociados a la cotización
            $this->load->library('crm');            
            $q = $this->crm->dar_vehiculos_de_pipeline($id_pipeline); 

            $data['vehiculos_pipeline'] = $q->relationship_list[0]->link_list[0];

            $vehiculos;
            
            foreach ($q->relationship_list[0]->link_list[0]->records as $i => $record)
            {
                $vehiculos[$i]->marca =  $record->link_value->name->value;
                $vehiculos[$i]->placa =  $record->link_value->placa->value;
                $vehiculos[$i]->modelo =  $record->link_value->modelo->value;
                $vehiculos[$i]->kilometraje =  $record->link_value->kilometraje->value;
                $vehiculos[$i]->cilindraje =  $record->link_value->cilindraje->value;
                $vehiculos[$i]->nro_vin =  $record->link_value->nro_vin->value;
            }

            

            $data['vehiculos'] = $vehiculos;
            
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
                )
            );
            $this->form_validation->set_rules($reglas);

            if(!$this->form_validation->run()){
                $this->form_validation->set_error_delimiters('', '');
                echo json_encode(array('status' => false, 'msg' => validation_errors()), JSON_HEX_QUOT | JSON_HEX_TAG);
            }else{
                $this->load->model('operacion/proveedor_model');
                $dataTemp = json_decode($this->input->post('items'), true);
                $id_usuario = $this->input->post('id_usuario');
                $id_pipeline = $this->input->post('id_pipeline');
                $itemsCot = array();
                $proveedoresCot = array();
                $cotizacionModel = new cotizacion_model();
                $cotizacionModel->id_pipeline = $id_pipeline;
                $cotizacionModel->dar_por_pipeline();
                foreach ($dataTemp as $data) {
                    $cantidad = $data[cantidad];
                    $elegido = $data[elegido];
                    $item = $data[item];
                    $uIDItem = $this->create_guid();
                    $precio = $data[precio];
                    $ivaprecio = $data[iva];
                    if(empty($item))
                        $item = ' ';
                    $margen = $data[margen];
                    $pSDco = $data[pSDco];
                    $dco = $data[dco];
                    $valido = $data[valido];
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
                        $proveedorCotizacionModel->lp_base = $ops[baseLP];
                        $proveedorCotizacionModel->iva = $ops[iva];
                        $proveedorCotizacionModel->nota = $ops[nota];
                        $proveedorCotizacionModel->elegido = $ops[elegido];
                        $proveedoresCot[$uIDItem][$provedor] = $proveedorCotizacionModel;//ud tiene el hp problema aquí yeahh

                        // echo 'ITEM '.$item.' ID PROVEEDOR '.$proveedorModel->id.' LPVALOR '.$proveedorCotizacionModel->lp_valor.' IVA '.$proveedorCotizacionModel->iva.' NOTA '.$proveedorCotizacionModel->nota.' ELEGIDO '.$proveedorCotizacionModel->elegido.'<br/>';

                        if($ops[elegido] == true && isset($ops[elegido])){
                            $ivaTmp = $ops[iva];
                            $costo = $ops[baseLP];
                            $ivaLP = $costo*($ivaTmp/100);
                            $lp_valor = $costo+$ivaLP;

                            $valor_antes_iva = $precio;
                            $cliente_iva = $valor_antes_iva*($ivaprecio/100);
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
                    }else{
                        $itemCotizacionModel->descartado = false;
                        if($cotizacionModel->id){
                            $items = $this->item_cotizacion_model->dar_todos_por_filtros(array('id_cotizacion' => $cotizacionModel->id,'item'=>$item));
                        }
                        if(sizeof($items)>0 && isset($items) )
                            $itemCotizacionModel->descartado = true;
                    }
                    $itemCotizacionModel->uIDItem = $uIDItem;
                    $itemCotizacionModel->item = $item;
                    $itemCotizacionModel->cantidad = $cantidad;
                    $itemCotizacionModel->margen = $margen;
                    $itemCotizacionModel->dco = $dco;
                    $itemCotizacionModel->precio_sin_dco = $pSDco;
                    $itemCotizacionModel->precio = $precio;
                    $itemCotizacionModel->iva = $ivaprecio;
                    $itemCotizacionModel->valido = $valido;
                    if(!isset($itemsCot[$item]))
                        $itemsCot[$item] = $itemCotizacionModel;
                }
                // echo  'COSTO: '.$Tcosto. ' LPIVA: '.   $Tlp_iva. ' LPVALOR: '.$Tlp_valor. ' IVACLIENTE: '.$Tcliente_iva. ' PRECIO: '.$Tcliente_precio . ' GANANCIA '.$Tganancia.'</br>';

                $cotizacionModel->id_usuario = $id_usuario;
                $cotizacionModel->costo = $Tcosto;
                $cotizacionModel->lp_iva = $Tlp_iva;
                $cotizacionModel->lp_valor = $Tlp_valor;
                $cotizacionModel->cliente_iva = $Tcliente_iva;
                $cotizacionModel->cliente_precio = $Tcliente_precio;
                $cotizacionModel->ganancia = $Tganancia;
                if($cotizacionModel->id){
                    $cotizacionModel->actualizar();
                }else{    
                    $cotizacionModel->insertar();
                }foreach ($itemsCot as $item) {
                    if(!$item->descartado){
                        $uIDTemp = $item->uIDItem;
                        unset($item->uIDItem);
                        unset($item->descartado);
                        if(!empty($item->id)){
                            $item->actualizar();
                        }else{
                            $item->id_cotizacion = $cotizacionModel->id;
                            $item->insertar();
                        }    
                        foreach ($proveedoresCot[$uIDTemp] as $proveedor) {
                            if(!empty($proveedor->id)){
                                $proveedor->actualizar();
                            }else{   
                                $proveedor->id_item_cotizacion = $item->id; 
                                $proveedor->insertar();
                            }
                        }
                    }
                }
                $this->guardarLog('cotizacion', 'ID PIPELINE: '.$id_pipeline.' ID USUARIO: '.$id_usuario.' Items: '.json_encode($dataTemp). "\n---------------------------------------------\n\n");
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

    /**
     * Envía la cotización en formato pdf al cliente
     */
    function enviar_cotizacion(){
        if($this->hay_sesion_activa()){
            $this->load->library('form_validation');
            $reglas = array(
                array(
                    'field' => 'id_pipeline',
                    'label' => 'id pipeline',
                    'rules' => 'trim|required|xss_clean'
                ),array(
                    'field' => 'id_usuario',
                    'label' => 'id usuario',
                    'rules' => 'trim|required|xss_clean'
                ),array(
                    'field' => 'nombres',
                    'label' => 'nombres',
                    'rules' => 'trim|required|xss_clean'
                ),array(
                    'field' => 'email',
                    'label' => 'email',
                    'rules' => 'trim|required|xss_clean'
                ),array(
                    'field' => 'documento',
                    'label' => 'documento',
                    'rules' => 'trim|xss_clean'
                ),array(
                    'field' => 'telefono',
                    'label' => 'teléfono',
                    'rules' => 'trim|xss_clean'
                ),array(
                    'field' => 'obsevaciones',
                    'label' => 'observaciones',
                    'rules' => 'trim|xss_clean'
                ),array(
                    'field' => 'ids_pc',
                    'label' => 'items seleccionados',
                    'rules' => 'trim|required|xss_clean'
                )
            );
            $this->form_validation->set_rules($reglas);

            if (!$this->form_validation->run()){
                $this->form_validation->set_error_delimiters('', '');
                echo json_encode(array('status' => false, 'msg' => validation_errors()), JSON_HEX_QUOT | JSON_HEX_TAG);
            }else {
                $this->load->model('operacion/item_orden_compra_model');
                $id_pipeline = $this->input->post('id_pipeline');
                $id_usuario = $this->input->post('id_usuario');
                $nombres = $this->input->post('nombres');
                $email = $this->input->post('email');
                $documento = $this->input->post('documento');
                $telefono = $this->input->post('telefono');
                $observaciones = $this->input->post('obsevaciones');
                $ids_pc = json_decode($this->input->post('ids_pc'), true);
                setlocale(LC_ALL, 'es_ES');
                define("CHARSET", "iso-8859-1");
                $this->load->model('usuario_model');
                $this->load->library('phptopdf');
                $cotizacion_model = new cotizacion_model();
                $cotizacion_model->id_pipeline = $id_pipeline;
                $cotizacion_model->dar_por_pipeline();
                $items = array();
                foreach ($ids_pc as $id) {
                    $item_orden_compra_model = new item_orden_compra_model();
                    $prov_model = new proveedor_cotizacion_model();
                    $prov_model->id = $id;
                    $prov_model->dar();
                    $item = $prov_model->dar_item_cotizacion();
                    $item->pc = $prov_model;
                    $items[] = $item;
                }
                $data['nombres'] = $nombres;
                $data['email'] = $email;
                $data['documento'] = $documento;
                $data['telefono'] = $telefono;
                $data['observaciones'] = $observaciones;
                $data['usuario'] = $this->usuario_model->dar_usuario($id_usuario);
                $data['cotizacion_model'] = $cotizacion_model;
                $data['itemsCot'] = $items;
                $html = $this->load->view('emails/formato_cotizacion_view', $data, true);
                $destinatarios = array();
                $destinatario = new stdClass();
                $destinatario->email = $email;
                $destinatarios[] = $destinatario;
                $destinatario = new stdClass();
                $destinatario->email = "tallerenlinea@laspartes.com.co";
                $destinatarios[] = $destinatario;
                $destinatario = new stdClass();
                $destinatario->email = "ventas@laspartes.com.co";
                $destinatarios[] = $destinatario;

                $this->load->helper('mail');
                $filePath = 'resources/cotizaciones/';
                $fileName = 'cotizacion-'.$cotizacion_model->id.'.pdf';
                $this->phptopdf->phptopdf_html($html, $filePath, $fileName);
                send_mail($destinatarios, "Cotización de compra LasPartes.com ", $html, "", $fileName, $filePath);
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

    private function create_guid() {
        $microTime = microtime();
        list($a_dec, $a_sec) = explode(" ", $microTime);

        $dec_hex = dechex($a_dec * 1000000);
        $sec_hex = dechex($a_sec);

        $this->ensure_length($dec_hex, 5);
        $this->ensure_length($sec_hex, 6);

        $guid = "";
        $guid .= $dec_hex;
        $guid .= $this->create_guid_section(3);
        $guid .= $this->create_guid_section(4);
        $guid .= $this->create_guid_section(4);
        $guid .= $this->create_guid_section(4);
        $guid .= $sec_hex;
        $guid .= $this->create_guid_section(6);

        return $guid;
    }


    private function create_guid_section($characters) {
        $return = "";
        for ($i = 0; $i < $characters; $i++) {
            $return .= dechex(mt_rand(0, 15));
        }
        return $return;
    }

    private function ensure_length(&$string, $length) {
        $strlen = strlen($string);
        if ($strlen < $length) {
            $string = str_pad($string, $length, "0");
        } else if ($strlen > $length) {
            $string = substr($string, 0, $length);
        }
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
        $fh = fopen($myFile, 'a+') or die("No se pudo abrir el archivo");
        fwrite($fh, $log);
        fclose($fh);
    }

    // function reindexar_op_proveedor_cotizacion(){
    //     $q = $this->db->get('op_proveedor_cotizacion');
    //     foreach ($q->result() as $obj) {
    //         $nuevoBase =  round($obj->lp_base / (1 + ($obj->iva/100)), 2);
    //         $this->db->set('lp_base', $nuevoBase);
    //         $this->db->where('id', $obj->id);
    //         $this->db->update('op_proveedor_cotizacion');
    //     }
    // }

    // function reindexar_op_item_cotizacion(){
    //     error_reporting(E_ALL);
    //     $cotizaciones = $this->cotizacion_model->dar_todos_por_filtros(array());
    //     foreach ($cotizaciones as $cotizacion) {
    //         $items = $cotizacion->dar_items_cotizacion();
    //         foreach ($items as $item) {
    //             $proovedores = $item->dar_proveedores_cotizacion();
    //             foreach ($proovedores as $proveedor) {
    //                 if($proveedor->elegido){
    //                     $precio = (1+($item->margen)/100)*($proveedor->lp_base);
    //                     $item->precio = $precio;
    //                     $item->dco = 0;
    //                     $item->precio_sin_dco = $proveedor->lp_base;
    //                     print_r('precio: '.$precio.'<br/>');
    //                     $item->actualizar();
    //                 }
    //             }
    //         }
    //     }

    // }

    // function crearProveedores(){
    //     $this->db->select('establecimientos.*, zonas.ciudad');
    //     $this->db->from('establecimientos');
    //     $this->db->join('zonas', 'establecimientos.id_zona = zonas.id_zona');
    //     $q = $this->db->get();

    //     foreach ($q->result() as $obj) {
    //         // var_dump($obj);
    //         $this->db->set('proveedor', $obj->nombre);
    //         $this->db->set('email', $obj->email);
    //         $this->db->set('direccion', $obj->direccion);
    //         $this->db->set('ciudad', $obj->ciudad);
    //         $this->db->set('telefono', $obj->telefonos);
    //         $this->db->insert('op_proveedores');
    //     }
    // }

}