<?php


/**
 * Clase que maneja la migracion de datos al CRM
 */
class Cotizaciones extends CI_Controller {

    /**
     * Constructor de la clase Usuario
     */
    function __construct() {
        parent::__construct();
        $this->load->model('operacion/proveedor_cotizacion_model');
        $this->load->model('operacion/cotizacion_model');
        $this->load->model('operacion/item_cotizacion_model');
    }

    function index() {
    }

    /**
     * Muestra el iFrame para realizar cotizaciones
     * @return [type] [description]
     */
    function mostrar_cotizaciones($id_pipeline, $id_usuario, $msj = ''){
        $this->load->model('establecimiento_model');
        $data['id_pipeline'] = $id_pipeline;
        $data['id_usuario'] = $id_usuario;
        $cotizacionModel = new cotizacion_model();
        $cotizacionModel->id_pipeline = $id_pipeline;
        $cotizacionModel->dar_por_pipeline();
        $items = $cotizacionModel->dar_items_cotizacion();
        $data['cotizacion'] = $cotizacionModel;
        foreach ($items as $item) {
            $item->proveedores = $item->dar_proveedores_cotizacion();
        }
        $data['items'] = $items;

        $establecimientos = $this->establecimiento_model->dar_establecimientos();
        $data['all_establecimientos'];
        $index = 0;
        foreach ($establecimientos as $establecimiento) {
            $data['all_establecimientos'][$index]->label = $establecimiento->nombre;
            $data['all_establecimientos'][$index]->email = $establecimiento->email;
            $index++;
        }
        $data['msj'] = $msj;
        $data['nombrevista'] = 'operacion/cotizacion/';
        $this->load->view('operacion/cotizacion/page', $data);
    }

    /**
     * guarda la información de la cotización
     * @return [type] [description]
     */
    function guardar(){
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
                $proveedorModel = new proveedor_cotizacion_model();
                if($ops[id_proveedor]){
                    $proveedorModel->id = $ops[id_proveedor];
                    $proveedorModel->dar();
                }
                $proveedorModel->proveedor = $provedor;
                $proveedorModel->email = $ops[email];
                $proveedorModel->lp_valor = $ops[valorLP];
                $proveedorModel->iva = $ops[iva];
                $proveedorModel->nota = $ops[nota];
                $proveedorModel->elegido = $ops[elegido];
                // $proveedorModel->orden_compra = ;
                $proveedoresCot[$item][$provedor] = $proveedorModel;

                if($ops[elegido] == true && isset($ops[elegido])){
                    $lp_valor = $ops[valorLP];
                    $ivaTmp = $ops[iva];
                    $costo = $lp_valor/(1+($ivaTmp/100));
                    $ivaLP = $costo*($ivaTmp/100);
                    $valor_antes_iva = $costo*$cantidad*(1+($margen/100));
                    $cliente_iva = $valor_antes_iva*($ivaTmp/100);
                    $cliente_precio = $valor_antes_iva + $cliente_iva;
                    $ganancia = $valor_antes_iva-$costo;
                    echo  'ITEM: '.$item.' MARGEN: '.$margen.' CANTIDAD: '.$cantidad.' VALORLP: '.$lp_valor. ' IVA: '.   $ivaTmp. ' COSTO: '.$costo. ' IVALP: '.$ivaLP. ' VALORANTES: '.$valor_antes_iva . ' PRECIOCLIENTE '.$cliente_precio.'<br/>------<br/>';

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
        echo  'COSTO: '.$Tcosto. ' LPIVA: '.   $Tlp_iva. ' LPVALOR: '.$Tlp_valor. ' IVACLIENTE: '.$Tcliente_iva. ' PRECIO: '.$Tcliente_precio . ' GANANCIA '.$Tganancia.'</br>';
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
    }

}