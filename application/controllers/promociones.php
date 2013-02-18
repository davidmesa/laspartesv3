<?php

require_once 'laspartes_controller.php';

//error_reporting(E_ALL);
//ini_set('display_errors', '1');

/**
 * Clase que maneja la página principal
 */
class Promociones extends Laspartes_Controller {

    /**
     * Constructor de la clase Inicio
     */
    function __construct() {
        parent::__construct();
    }

    /**
     * Da detalles de una autoparte
     * @param int $id_autoparte
     * @param String $orden
     * @return array con $autoparte, $autoparte_vehiculos, $marcas, $establecimientos
     */
    function _ver_promocion($id_oferta, $orden, $categoria,  $vehiculoMarca, $vehiculoLinea){
        $this->load->model('autoparte_model');
        $this->load->model('establecimiento_model');
        $this->load->model('usuario_model');
        $this->load->model('vehiculo_model');
        $this->load->model('promocion_model');
        $data['promocion'] = $this->promocion_model->dar_oferta($id_oferta);
        $data['promocion_vehiculos'] = $this->promocion_model->dar_oferta_vehiculos($id_oferta);
        
        //-----------
        $a = str_replace('-', ' ', convert_accented_characters($categoria));
        $c = str_replace('_', ' ', convert_accented_characters($vehiculoMarca));
        $d = str_replace('-', ' ', convert_accented_characters($vehiculoLinea));
        $data['categorias'] = $this->promocion_model->dar_ofertas_categorias_filtros($c, $d); 
        
        $data['allvehiculos'] = $this->vehiculo_model->dar_vehiculos();
        $index = 0;
        foreach ($data['allvehiculos'] as $vehiculo) {
            $data['allvehiculos'][$index]->label = str_replace(" ","_", $vehiculo->marca) . ' ' . $vehiculo->linea;
            $data['allvehiculos'][$index]->value = str_replace(" ","_", $vehiculo->marca) . ' ' . $vehiculo->linea;
            $index++;
        }
        return $data;
    }
    
    function _ver_promociones($limit, $offset, $orden, $categoria, $marca_vehiculo, $linea_vehiculo){
        $offset = $offset -1;
        $this->load->model('vehiculo_model');
        $this->load->model('promocion_model');
        $a = str_replace('-', ' ', convert_accented_characters($categoria));
        $c = str_replace('_', ' ', convert_accented_characters($marca_vehiculo));
        $d = str_replace('-', ' ', convert_accented_characters($linea_vehiculo));
        $data['promociones'] = $this->promocion_model->dar_ofertas_paginacion_filtros($limit, $offset, $orden, $a, $c, $d);
        $data['cantidadPromociones'] = (int)($this->promocion_model->dar_ofertas_cantidad($a, $c, $d)/10)+1; 
        $data['categorias'] = $this->promocion_model->dar_ofertas_categorias_filtros($c, $d); 
        
        //da la lista de vehículos para el autocomplete
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
     * Muestra la página principal
     */
    function index($mensaje ='') {
        setlocale(LC_ALL,'es_ES');
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
                }elseif ($urlArray[$i]=='pagina') {
                    $i++;
                    $pagina = $urlArray[$i]+0;
                }
            }
        }
        $data = $this->_ver_promociones(10, $pagina, $order, $categoria, $vehiculoMarca, $vehiculoLinea);

        $this->load->model('generico_model');
        $data['categoriaBusqueda'] = $categoria;
        if(isset($categoria)){
            $categoriaObj = $this->generico_model->dar_tildes('servicios_categoria', 'nombre', str_replace('-', ' ', $categoria));
            $data['categoriaBusqueda'] = $categoriaObj->nombre;
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
        $data['limit'] = $pagina;
        
        $keywords = '';
        foreach ($data['categorias'] as $servi):
            $keywords .= ','.$servi->nombre;
        endforeach;
        $data['metaKeywords'] = 'autopartes,repuestos,promociones,descuentos,ofertas,tarifas,precios,promo,rebajas,'.$keywords;
        $data['metaDescripcion'] = 'Las mejores ofertas y promociones para tu vehículo!';
        $data['metaImagen'] = 'resources/images/home/noticias/baner-ofertas.png';
        $data['titulo'] = 'Laspartes.com :: Ofertas y promociones';
        $data['breadcrumb'] = '<div><a href="' . base_url() . '">Inicio</a></div> <div class="div-breadcrumb-espaciador"></div> <div>Ofertas y promociones</div>';
        $data['header_view'] = 'promocion/header/promocion_view';
        $data['navegacion_view'] = 'promociones';
        $data['contenido_view'] = 'promocion/promocion_view';
        $this->load->view('template/template', $data);
    }
    
    function ver_promocion($id_promo, $titulo_promo){
        setlocale(LC_ALL,'es_ES');
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
                }elseif ($urlArray[$i]=='pagina') {
                    $i++;
                    $pagina = $urlArray[$i]+0;
                }
            }
        }
        
        $data = $this->_ver_promocion($id_promo, $orden, $categoria, $vehiculoMarca, $vehiculoLinea);
        
        $this->load->model('generico_model');
        $data['categoriaBusqueda'] = $categoria;
        if(isset($categoria)){
            $categoriaObj = $this->generico_model->dar_tildes('servicios_categoria', 'nombre', str_replace('-', ' ', $categoria));
            $data['categoriaBusqueda'] = $categoriaObj->nombre;
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

        if(sizeof($data['promocion'])==0 ){
            $data['titulo'] = 'Página no Encontrada';
            $data['breadcrumb'] = '<div><a href="' . base_url() . '">Inicio</a></div> <div class="div-breadcrumb-espaciador"></div> <div><a href="'.base_url().'autopartes">Autopartes</a></div><div class="div-breadcrumb-espaciador"></div><div>Página no encontrada - Lo sentimos</div>';
            $data['header_view'] = 'error/404/header/404_view';
            $data['navegacion_view'] = 'promociones';
            $data['contenido_view'] = 'error/404/404_view';
            $this->load->view('template/template', $data);
        }
        else{
        
            $data['orden'] = $orden;
            $data['titulo'] = $data['promocion']->titulo;
            $data['breadcrumb'] = '<div><a href="' . base_url() . '">Inicio</a></div> <div class="div-breadcrumb-espaciador"></div> <div><a href="'.base_url().'promociones">Ofertas y promociones</a></div><div class="div-breadcrumb-espaciador"></div><div>'.$data['promocion']->titulo.'</div>';
            $data['header_view'] = 'promocion/header/promocion_detalle_view';
            $data['navegacion_view'] = 'promociones';
            $data['contenido_view'] = 'promocion/promocion_detalle_view';
            $this->load->view('template/template', $data);
        }
        
    }
    
    
    

}