<?php

/**
 * Clase que maneja la BD en donde las consultas se concentra en la tabla establecimientos
 */
class Excel_model extends CI_Model{

    /**
     * Constructor de la clase Establecimiento_model
     */
    function __construct(){
        parent::__construct();
    }
    
    function dar_establecimientos(){
    	$query = $this->db->get('establecimientos');
    	return $query->result();
    }
    
    function dar_autoparte($id_establecimiento, $nombre, $marca, $precio){
    	$this->db->escape($nombre);
        $this->db->escape($marca);
        $this->db->escape($precio);
    	$this->db->select('establecimientos_autopartes.*, autopartes.nombre, autopartes_marcas.nombre as nombre_marca');
        $this->db->from('autopartes');
    	$this->db->join('establecimientos_autopartes', 'establecimientos_autopartes.id_autoparte = autopartes.id_autoparte');
    	$this->db->join('autopartes_marcas', 'autopartes_marcas.id_autoparte_marca = autopartes.id_autoparte_marca');
    	$this->db->where('establecimientos_autopartes.id_establecimiento', $id_establecimiento);
    	$this->db->where('autopartes.nombre', $nombre);
    	$this->db->where('autopartes_marcas.nombre', $marca);
    	$this->db->where('establecimientos_autopartes.precio', $precio);
        $query = $this->db->get();
    	return $query->row(0);
    }
    
    function dar_autoparte_b($nombre, $id_marca){
    	$this->db->escape($nombre);
        $this->db->escape($marca);
    	$this->db->where('nombre', $nombre);
        $this->db->where('id_autoparte_marca', $id_marca);
		$query = $this->db->get('autopartes');
    	return $query->row();
    }
    
    function agregar_establecimiento_autoparte($id_establecimiento, $nombre, $id_marca, $precio, $inicio, $fin, $original, $observacion, $categoria, $origen, $descripcion){
    	$id_autoparte = $this->_agregar_autoparte($nombre, $id_marca, $categoria, $origen, $descripcion);
//        echo $observacion.'-'.$descripcion.'<br/>';
       	$this->db->escape($id_establecimiento);
    	$this->db->escape($id_autoparte);
    	$this->db->escape($precio);
        $this->db->set('id_establecimiento', $id_establecimiento);
        $this->db->set('id_autoparte', $id_autoparte);
        $this->db->set('precio', $precio);
        $this->db->set('ano_inicio', $inicio);
        $this->db->set('ano_fin', $fin);
        $this->db->set('original', $original);
        $this->db->set('observacion', $observacion);
        $this->db->insert('establecimientos_autopartes');
    }
    
    function _agregar_autoparte($nombre, $id_marca, $categoria, $origen, $descripcion){
        $this->db->where('nombre', $categoria);
        $id_categoria = $this->db->get('autopartes_categorias')->row(0);
    	$this->db->escape($nombre);
        $this->db->escape($id_marca);
        $this->db->set('id_autoparte_marca', $id_marca);
        $this->db->set('nombre', $nombre);
        $this->db->set('origen', $origen);
        $this->db->set('id_autoparte_categoria', $id_categoria->id_autoparte_categoria);
        $this->db->set('descripcion', $descripcion);
        $this->db->set('estado', 'Activo');
        $this->db->insert('autopartes');
        return mysql_insert_id();
    }
    
    
    
    function dar_vehiculo($linea, $marca){
    	$this->db->escape($linea);
    	$this->db->where('linea', $linea);
        $this->db->where('marca', $marca);
    	$query = $this->db->get('vehiculos');
        if($query->row()){
            return $query->row();
        }else{
            $this->db->set('linea', $linea);
            $this->db->set('marca', $marca);
            $this->db->insert('vehiculos');
            $this->db->where('linea', $linea);
            $this->db->where('marca', $marca);
            $query = $this->db->get('vehiculos');
            return $query->row();
        }
    }
    
    function dar_autoparte_vehiculo($id_autoparte, $id_vehiculo){
    	$this->db->where('id_autoparte', $id_autoparte);
    	$this->db->where('id_vehiculo', $id_vehiculo);
    	$query = $this->db->get('autopartes_vehiculos');
    	return $query->row();
    }
    
    function agregar_autoparte_vehiculo($id_autoparte, $id_vehiculo){
    	$this->db->escape($id_autoparte);
        $this->db->escape($id_vehiculo);
        $this->db->set('id_autoparte', $id_autoparte);
        $this->db->set('id_vehiculo', $id_vehiculo);
        $this->db->insert('autopartes_vehiculos');
    }
    
    function dar_marca_autoparte($marca){ 
    	$this->db->escape($marca);
    	$this->db->where('nombre', $marca);
    	$query = $this->db->get('autopartes_marcas');
    	if(!$query->row()){
             $this->db->set('nombre', $marca);
            $this->db->insert('autopartes_marcas');
            return mysql_insert_id();
        }else{
            return $query->row()->id_autoparte_marca;
        }
    }
    
    /**
     * Da los datos de un vehiculo
     * @param int $id_vehiculo
     * @return object $vehiculo
     */
    function dar_vehiculo_tipo_marca($tipo = 3, $marca=''){
        $this->db->escape($tipo);
        $this->db->escape($marca);
        if($marca!='')
            $this->db->where('marca', $marca);
        if($tipo != 3)
            $this->db->where('tipo', $tipo);
        $query = $this->db->get('vehiculos');
        return $query->result();
    }
    
    function dar_id_servicios_categoria($categoria){
       $this->db->escape($categoria); 
       $this->db->where('nombre',$categoria);
       $query= $this->db->get('servicios_categoria');
        if ($query->num_rows() != 0){
            return $query->row(0)->id_servicios_categoria;
        }else{
            $this->db->set('nombre', $categoria);
            $this->db->insert('servicios_categoria');
            return mysql_insert_id();
        }
    }
        
    function agregar_promocion($titulo, $precio, $iva, $condiciones, $incluye,$vigencia, $margenLP, $dcoOferta, $plazo){
        $this->db->escape($titulo);
        $this->db->escape($precio);
        $this->db->escape($iva);
        $this->db->escape($condiciones);
        $this->db->escape($incluye);
        $this->db->escape($vigencia);
        $this->db->escape($margenLP);
        $this->db->escape($dcoOferta);
        $this->db->escape($plazo);
        $this->db->set('titulo', $titulo);
        $this->db->set('precio', $precio);
        $this->db->set('iva', $iva);
        $this->db->set('condiciones', $condiciones);
        $this->db->set('incluye', $incluye);
        $this->db->set('vigencia', $vigencia);
        $this->db->set('margenLP', $margenLP);
        $this->db->set('dco_feria', $dcoOferta);
        $this->db->set('plazo_uso', $plazo);
        $this->db->insert('oferta');
        return mysql_insert_id();
    }
    
    function agregar_establecimiento_promocion($id_vehiculo, $id_categoria, $id_oferta, $id_establecimiento){
        $this->db->escape($id_vehiculo);
        $this->db->escape($id_categoria);
        $this->db->escape($id_oferta);
        $this->db->escape($id_establecimiento);
        $this->db->set('id_establecimiento',$id_establecimiento);
        $this->db->set('id_oferta',$id_oferta);
        $this->db->set('id_servicios_categoria',$id_categoria);
        $this->db->set('id_vehiculo',$id_vehiculo);
        $this->db->insert('establecimientos_ofertas');
    }
}