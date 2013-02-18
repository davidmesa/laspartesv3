<?php

/**
 * Clase que maneja la BD en donde las consultas se concentra en las tablas
 * autopartes, autopartes_marca, autopartes_categorias, autopartes_vehiculos
 */
class Autoparte_model extends CI_Model{

    /**
     * Constructor de la clase Autoparte_model
     */
    function __construct(){
        parent::__construct();
    }

    /**
     * Actualiza una autoparte
     * @param int $id_autoparte
     * @param String $nombre
     * @param int $id_autoparte_marca
     * @param int $id_autoparte_categoria
     * @param String $descripcion
     * @param String $origen
     * @param String $referencia
     * @param String $estado
     */
    function actualizar_autoparte($id_autoparte, $nombre, $id_autoparte_marca, $id_autoparte_categoria, $descripcion, $origen, $referencia, $estado){
        $this->db->escape($id_autoparte);
        $this->db->escape($nombre);
        $this->db->escape($id_autoparte_marca);
        $this->db->escape($id_autoparte_categoria);
        $this->db->escape($descripcion);
        $this->db->escape($origen);
        $this->db->escape($referencia);
        $this->db->escape($estado);
        $this->db->set('nombre', $nombre);
        $this->db->set('id_autoparte_marca', $id_autoparte_marca);
        $this->db->set('id_autoparte_categoria', $id_autoparte_categoria);
        $this->db->set('descripcion', $descripcion);
        $this->db->set('origen', $origen);
        $this->db->set('referencia', $referencia);
        $this->db->set('estado', $estado);
        $this->db->where('id_autoparte', $id_autoparte);
        $this->db->limit(1);
        $this->db->update('autopartes');
    }

    /**
     * Actualiza una categoria
     * @param int $id_autoparte_categoria
     * @param String $nombre
     */
    function actualizar_autoparte_categoria($id_autoparte_categoria, $nombre){
        $this->db->escape($id_autoparte_categoria);
        $this->db->escape($nombre);
        $this->db->set('nombre', $nombre);
        $this->db->where('id_autoparte_categoria', $id_autoparte_categoria);
        $this->db->limit(1);
        $this->db->update('autopartes_categorias');
    }

    /**
     * Actualiza la URL de una imagen de una autoparte
     * @param int $id_autoparte
     * @param String $imagen_url
     * @param String $imagen_thumb_url
     */
    function actualizar_autoparte_imagen_url($id_autoparte, $imagen_url, $imagen_thumb_url){
        $this->db->escape($id_autoparte);
        $this->db->escape($imagen_url);
        $this->db->escape($imagen_thumb_url);
        $this->db->set('imagen_url', $imagen_url);
        $this->db->set('imagen_thumb_url', $imagen_thumb_url);
        $this->db->where('id_autoparte', $id_autoparte);
        $this->db->limit(1);
        $this->db->update('autopartes');
    }

    /**
     * Actualiza una marca
     * @param int $id_autoparte_marca
     * @param String $nombre
     */
    function actualizar_autoparte_marca($id_autoparte_marca, $nombre){
        $this->db->escape($id_autoparte_marca);
        $this->db->escape($nombre);
        $this->db->set('nombre', $nombre);
        $this->db->where('id_autoparte_marca', $id_autoparte_marca);
        $this->db->limit(1);
        $this->db->update('autopartes_marcas');
    }

    /**
     * Actualiza en número de visitas de una autoparte
     * @param int $id_autoparte
     */
    function actualizar_numero_visitas($id_autoparte){
        $this->db->escape($id_autoparte);
        $this->db->set('numero_visitas', 'numero_visitas+1', FALSE);
        $this->db->where('id_autoparte', $id_autoparte);
        $this->db->limit(1);
        $this->db->update('autopartes');
    }

    /**
     * Agrega una nueva autoparte
     * @param String $nombre
     * @param int $id_autoparte_marca
     * @param int $id_autoparte_categoria
     * @param String $descripcion
     * @param String $origen
     * @param String $referencia
     * @param String $estado
     * @return int $id_autoparte
     */
    function agregar_autoparte($nombre, $id_autoparte_marca, $id_autoparte_categoria, $descripcion, $origen, $referencia, $estado){
        $this->db->escape($nombre);
        $this->db->escape($id_autoparte_marca);
        $this->db->escape($id_autoparte_categoria);
        $this->db->escape($descripcion);
        $this->db->escape($origen);
        $this->db->escape($referencia);
        $this->db->escape($estado);
        $this->db->set('nombre', $nombre);
        $this->db->set('id_autoparte_marca', $id_autoparte_marca);
        $this->db->set('id_autoparte_categoria', $id_autoparte_categoria);
        $this->db->set('descripcion', $descripcion);
        $this->db->set('origen', $origen);
        $this->db->set('referencia', $referencia);
        $this->db->set('estado', $estado);
        $this->db->insert('autopartes');
        return mysql_insert_id();
    }

    /**
     * Agrega una nueva categoría
     * @param String $nombre
     */
    function agregar_autoparte_categoria($nombre){
        $this->db->escape($nombre);
        $this->db->set('nombre', $nombre);
        $this->db->insert('autopartes_categorias');
    }

    /**
     * Agrega una nueva marca
     * @param String $nombre
     */
    function agregar_autoparte_marca($nombre){
        $this->db->escape($nombre);
        $this->db->set('nombre', $nombre);
        $this->db->insert('autopartes_marcas');
    }

    /**
     * Agrega una relación autoparte-vehículo
     * @param int $id_autoparte
     * @param int $id_vehiculo
     */
    function agregar_autoparte_vehiculo($id_autoparte, $id_vehiculo){
        $this->db->escape($id_autoparte);
        $this->db->escape($id_vehiculo);
        $this->db->set('id_autoparte', $id_autoparte);
        $this->db->set('id_vehiculo', $id_vehiculo);
        $this->db->insert('autopartes_vehiculos');
    }

    /**
     * Cuenta el número de autopartes con los filtros deseados
     * @param String $categoria
     * @param String $marca
     * @return $numero_autopartes
     */
    function contar_autopartes($categoria, $marca, $vehiculo, $linea){
        $this->db->select('autopartes.id_autoparte, autopartes_categorias.nombre AS categoria, autopartes_marcas.nombre AS marca, autopartes.nombre, descripcion, imagen_thumb_url, origen, referencia, min(precio) AS precio');
        $this->db->join('autopartes_categorias', 'autopartes_categorias.id_autoparte_categoria = autopartes.id_autoparte_categoria');
        $this->db->join('autopartes_marcas', 'autopartes_marcas.id_autoparte_marca = autopartes.id_autoparte_marca');
        $this->db->join('establecimientos_autopartes', 'establecimientos_autopartes.id_autoparte = autopartes.id_autoparte');
        $this->db->join('autopartes_vehiculos', 'autopartes.id_autoparte = autopartes_vehiculos.id_autoparte');
        $this->db->join('vehiculos', 'autopartes_vehiculos.id_vehiculo = vehiculos.id_vehiculo');

        if($categoria!='todas las categorias')
            $this->db->where('autopartes_categorias.nombre', $categoria);
        if($marca!='todas las marcas')
            $this->db->where('autopartes_marcas.nombre', $marca);
        if($vehiculo!='todas las marcas')
            $this->db->where('vehiculos.marca', $vehiculo);
        if($linea!='todas las lineas')
            $this->db->where('vehiculos.linea', $linea);

        $this->db->group_by('establecimientos_autopartes.id_autoparte');
        $this->db->where('autopartes.estado', 'Activo');
        $query = $this->db->get('autopartes');
        return $query->num_rows();
    }

    /**
     * Da los datos de una autoparte
     * @param int $id_autoparte
     * @return object $autoparte
     */
    function dar_autoparte($id_autoparte){
        $this->db->escape($id_autoparte);
        $this->db->select('autopartes.id_autoparte, autopartes.id_autoparte_marca, autopartes.id_autoparte_categoria, autopartes.nombre, establecimientos_autopartes.observacion,
            autopartes.descripcion, autopartes.imagen_url, autopartes.imagen_thumb_url, origen, referencia, autopartes.estado, autopartes_marcas.nombre AS marca');
        $this->db->join('autopartes_marcas', 'autopartes.id_autoparte_marca=autopartes_marcas.id_autoparte_marca');
        $this->db->join('establecimientos_autopartes','establecimientos_autopartes.id_autoparte = autopartes.id_autoparte');
        $this->db->where('autopartes.id_autoparte', $id_autoparte);
        $this->db->limit(1);
        $query = $this->db->get('autopartes');
        return $query->row(0);
    }

    /**
     * Da los ids de las autopartes buscadas
     * @param String nombre
     * @param int $id_autoparte_marca
     * @param int $id_autoparte_categoria
     * @param String $descripcion
     * @param String $origen
     * @param String $referencia
     * @return object $autoparte
     */
    function dar_autoparte_ids($nombre, $id_autoparte_marca, $id_autoparte_categoria, $descripcion, $origen, $referencia){
        $this->db->escape($nombre);
        $this->db->escape($id_autoparte_marca);
        $this->db->escape($id_autoparte_categoria);
        $this->db->escape($descripcion);
        $this->db->escape($origen);
        $this->db->escape($referencia);
        $this->db->select('id_autoparte');
        $this->db->where('nombre', $nombre);
        $this->db->where('id_autoparte_marca', $id_autoparte_marca);
        $this->db->where('id_autoparte_categoria', $id_autoparte_categoria);
        $this->db->where('descripcion', $descripcion);
        $this->db->where('origen', $origen);
        $this->db->where('referencia', $referencia);
        $query = $this->db->get('autopartes');
        return $query->result();
    }

    /**
     * Da una autoparte con la información de un establecimiento
     * @param int $id_autoparte
     * @param int $id_establecimiento
     * @return object $autoparte_establecimiento
     */
    function dar_autoparte_establecimiento($id_autoparte, $id_establecimiento){
        $this->db->escape($id_autoparte);
        $this->db->escape($id_establecimiento);
        $this->db->select('autopartes.id_autoparte, autopartes.nombre, autopartes.descripcion, precio, autopartes.imagen_url as imagen, autopartes.imagen_thumb_url as thumb,
            establecimientos.id_establecimiento, establecimientos.nombre AS establecimiento, vehiculos.marca, vehiculos.linea, autopartes_marcas.nombre as vehiculo_marca');
        $this->db->join('establecimientos_autopartes', 'autopartes.id_autoparte=establecimientos_autopartes.id_autoparte');
        $this->db->join('establecimientos', 'establecimientos_autopartes.id_establecimiento=establecimientos.id_establecimiento');
        $this->db->join('autopartes_vehiculos', 'autopartes_vehiculos.id_autoparte = autopartes.id_autoparte');
        $this->db->join('autopartes_marcas', 'autopartes_marcas.id_autoparte_marca = autopartes.id_autoparte_marca');
        $this->db->join('vehiculos', 'vehiculos.id_vehiculo = autopartes_vehiculos.id_vehiculo');
        $this->db->where('autopartes.id_autoparte', $id_autoparte);
        $this->db->where('establecimientos_autopartes.id_establecimiento', $id_establecimiento);
        $this->db->limit(1);
        $query = $this->db->get('autopartes');
        return $query->row(0);
    }
    
    function dar_autoparte_establecimiento_primero($id_autoparte){
        $this->db->escape($id_autoparte);
        $this->db->select('autopartes.id_autoparte, autopartes.nombre, autopartes.descripcion, precio, autopartes.imagen_url as imagen, autopartes.imagen_thumb_url as thumb,
            establecimientos.id_establecimiento, establecimientos.nombre AS establecimiento, vehiculos.marca, vehiculos.linea, autopartes_marcas.nombre as vehiculo_marca');
        $this->db->join('establecimientos_autopartes', 'autopartes.id_autoparte=establecimientos_autopartes.id_autoparte');
        $this->db->join('establecimientos', 'establecimientos_autopartes.id_establecimiento=establecimientos.id_establecimiento');
        $this->db->join('autopartes_vehiculos', 'autopartes_vehiculos.id_autoparte = autopartes.id_autoparte');
        $this->db->join('autopartes_marcas', 'autopartes_marcas.id_autoparte_marca = autopartes.id_autoparte_marca');
        $this->db->join('vehiculos', 'vehiculos.id_vehiculo = autopartes_vehiculos.id_vehiculo');
        $this->db->where('autopartes.id_autoparte', $id_autoparte);
        $this->db->limit(1);
        $query = $this->db->get('autopartes');
        return $query->row(0);
    }

    /**
     * Da los datos de una categoria
     * @param int $id_autoparte_categoria
     * @return object $categoria
     */
    function dar_autoparte_categoria($id_autoparte_categoria){
        $this->db->escape($id_autoparte_categoria);
        $this->db->where('id_autoparte_categoria', $id_autoparte_categoria);
        $this->db->limit(1);
        $query = $this->db->get('autopartes_categorias');
        return $query->row(0);
    }

    /**
     * Da los datos de una marca
     * @param int $id_autoparte_marca
     * @return object $marca
     */
    function dar_autoparte_marca($id_autoparte_marca){
        $this->db->escape($id_autoparte_marca);
        $this->db->where('id_autoparte_marca', $id_autoparte_marca);
        $this->db->limit(1);
        $query = $this->db->get('autopartes_marcas');
        return $query->row(0);
    }

    /**
     * Da el precio mínimo y máximo de una autoparte
     * @param int $id_autoparte
     * @return array $rango_precios
     */
    function dar_autoparte_rango_precios($id_autoparte){
        $this->db->escape($id_autoparte);
        $this->db->select('min(precio) AS precio_minimo, max(precio) AS precio_maximo');
        $this->db->join('establecimientos', 'establecimientos.id_establecimiento = establecimientos_autopartes.id_establecimiento');
        $this->db->where('establecimientos_autopartes.id_autoparte', $id_autoparte);
        $this->db->where('estado', 'Activo');
        $this->db->limit(1);
        $query = $this->db->get('establecimientos_autopartes');
        return $query->row(0);
    }

    /**
     * Da los vehículos asociados a una autoparte
     * @param int $id_autoparte
     * @return array $vehiculos
     */
    function dar_autoparte_vehiculos_distinct($id_autoparte){
        $this->db->escape($id_autoparte);
        $this->db->select('marca');
        $this->db->join('autopartes_vehiculos', 'autopartes_vehiculos.id_vehiculo = vehiculos.id_vehiculo');
        $this->db->where('id_autoparte', $id_autoparte);
        $this->db->group_by('marca');
        $this->db->order_by('marca', 'asc');
        $query = $this->db->get('vehiculos');
        return $query->result();
    }
    
    /**
     * Da los vehículos asociados a una autoparte
     * @param int $id_autoparte
     * @return array $vehiculos
     */
    function dar_autoparte_vehiculos($id_autoparte){
        $this->db->escape($id_autoparte);
        $this->db->select('autopartes_vehiculos.id_vehiculo, marca, linea');
        $this->db->join('autopartes_vehiculos', 'autopartes_vehiculos.id_vehiculo = vehiculos.id_vehiculo');
        $this->db->where('id_autoparte', $id_autoparte);
        $this->db->order_by('marca', 'asc');
        $query = $this->db->get('vehiculos');
        return $query->result();
    }

    /**
     * Da la lista de autopartes
     * @return array $autopartes
     */
    function dar_autopartes(){
        $this->db->select('autopartes.id_autoparte, autopartes.id_autoparte_categoria, autopartes_categorias.nombre AS categoria, autopartes.id_autoparte_marca, autopartes_marcas.nombre AS marca, autopartes.nombre, autopartes.estado, origen, descripcion, referencia');
        $this->db->join('autopartes_categorias', 'autopartes_categorias.id_autoparte_categoria = autopartes.id_autoparte_categoria');
        $this->db->join('autopartes_marcas', 'autopartes_marcas.id_autoparte_marca = autopartes.id_autoparte_marca');
        $this->db->order_by('autopartes.id_autoparte', 'asc');
        $query = $this->db->get('autopartes');
        return $query->result();
    }

    /**
     * Da la lista de autopartes con el formato de autocomplete de JQueryUI
     * @param int $id_establecimiento
     * @return array $autopartes_autocomplete
     */
    function dar_autopartes_autocomplete(){
        $this->db->select('autopartes.id_autoparte, autopartes.id_autoparte_categoria, autopartes_categorias.nombre AS categoria, autopartes.id_autoparte_marca, autopartes_marcas.nombre AS marca, autopartes.nombre, autopartes.nombre AS label, autopartes.nombre AS value, autopartes.estado, origen, descripcion, referencia');
        $this->db->distinct();
        $this->db->join('autopartes_categorias', 'autopartes_categorias.id_autoparte_categoria = autopartes.id_autoparte_categoria');
        $this->db->join('autopartes_marcas', 'autopartes_marcas.id_autoparte_marca = autopartes.id_autoparte_marca');
        $this->db->order_by('autopartes.id_autoparte', 'asc');
        $query = $this->db->get('autopartes');
        return $query->result();
    }

    /**
     * Da las 3 autopartes con mayor número de visitas
     * @return array $autopartes
     */
    function dar_autopartes_mayor_numero_visitas(){
        $this->db->select('autopartes.id_autoparte, autopartes_categorias.nombre AS categoria, autopartes_marcas.nombre AS marca, autopartes.nombre, autopartes.estado, origen');
        $this->db->join('autopartes_categorias', 'autopartes_categorias.id_autoparte_categoria = autopartes.id_autoparte_categoria');
        $this->db->join('autopartes_marcas', 'autopartes_marcas.id_autoparte_marca = autopartes.id_autoparte_marca');
        $this->db->order_by('numero_visitas', 'desc');
        $this->db->limit(10);
        $query = $this->db->get('autopartes');
        return $query->result();
    }

    /**
     * Da la lista de autopartes con paginación y filtros
     * @param int $limit
     * @param int $offset
     * @param String $orden
     * @param String $categoria
     * @param String $marca
     * @return array $autopartes
     */
    function dar_autopartes_paginacion_filtros($limit, $offset, $orden, $categoria, $marca, $vehiculo, $linea){
        $this->db->select('autopartes.id_autoparte, autopartes_categorias.nombre AS categoria, 
            autopartes_marcas.nombre AS marca, autopartes.nombre, descripcion, imagen_thumb_url, imagen_url,
            origen, referencia, min(precio) AS precio, count(distinct(establecimientos_autopartes.id_establecimiento)) as numEstablecimientos, vehiculos.marca as vehiculo_marca
            , vehiculos.linea as vehiculo_linea');
        $this->db->join('autopartes_categorias', 'autopartes_categorias.id_autoparte_categoria = autopartes.id_autoparte_categoria');
        $this->db->join('autopartes_marcas', 'autopartes_marcas.id_autoparte_marca = autopartes.id_autoparte_marca');
        $this->db->join('establecimientos_autopartes', 'establecimientos_autopartes.id_autoparte = autopartes.id_autoparte');
        $this->db->join('autopartes_vehiculos', 'autopartes_vehiculos.id_autoparte = autopartes.id_autoparte');
        $this->db->join('vehiculos', 'vehiculos.id_vehiculo = autopartes_vehiculos.id_vehiculo');
        if($categoria != '')
            $this->db->where('autopartes_categorias.nombre', $categoria);
        if($marca != '')
            $this->db->where('autopartes_marcas.nombre', $marca);
        if($vehiculo != '')
            $this->db->like('vehiculos.marca', str_replace ("_", " ", $vehiculo));
        if($linea != '')
            $this->db->like('vehiculos.linea', $linea);
        $this->db->group_by('establecimientos_autopartes.id_autoparte');
        if($orden=='precio')
            $this->db->order_by('establecimientos_autopartes.precio', 'desc');
        else{
             $this->db->order_by('vehiculo_linea', 'asc');
             $this->db->order_by('autopartes.nombre', 'asc');
        }
           
        $this->db->where('autopartes.estado', 'Activo');
        $this->db->limit($limit, $offset*10);
        $query = $this->db->get('autopartes');
        return $query->result();
    }
    
    function dar_autopartes_filtros_vehiculo( $marca,$linea ){
        $this->db->select('autopartes.id_autoparte, autopartes_categorias.nombre AS categoria, 
            autopartes_marcas.nombre AS marca, autopartes.nombre, vehiculos.marca as vehiculo_marca');
        $this->db->join('autopartes_categorias', 'autopartes_categorias.id_autoparte_categoria = autopartes.id_autoparte_categoria');
        $this->db->join('autopartes_marcas', 'autopartes_marcas.id_autoparte_marca = autopartes.id_autoparte_marca');
        $this->db->join('establecimientos_autopartes', 'establecimientos_autopartes.id_autoparte = autopartes.id_autoparte');
        $this->db->join('autopartes_vehiculos', 'autopartes_vehiculos.id_autoparte = autopartes.id_autoparte');
        $this->db->join('vehiculos', 'vehiculos.id_vehiculo = autopartes_vehiculos.id_vehiculo');
        if( $marca != '' && $linea != '' ) {
                $this->db->where('vehiculos.marca', $marca);
                $this->db->where('vehiculos.linea', $linea);
        }
        $this->db->order_by('autopartes.nombre', 'asc');
           
        $this->db->where('autopartes.estado', 'Activo');
        $query = $this->db->get('autopartes');
        return $query->result();
    }
    
    /**
     * Da la lista de autopartes con paginación y filtros
     * @param int $limit
     * @param int $offset
     * @param String $orden
     * @param String $categoria
     * @param String $marca
     * @return array $autopartes
     */
    function dar_autopartes_paginacion_filtros_cantidad($categoria, $marca, $vehiculo, $linea){
        $this->db->join('autopartes_categorias', 'autopartes_categorias.id_autoparte_categoria = autopartes.id_autoparte_categoria');
        $this->db->join('autopartes_marcas', 'autopartes_marcas.id_autoparte_marca = autopartes.id_autoparte_marca');
        $this->db->join('establecimientos_autopartes', 'establecimientos_autopartes.id_autoparte = autopartes.id_autoparte');
        $this->db->join('autopartes_vehiculos', 'autopartes_vehiculos.id_autoparte = autopartes.id_autoparte');
        $this->db->join('vehiculos', 'vehiculos.id_vehiculo = autopartes_vehiculos.id_vehiculo');
        if($categoria != '')
            $this->db->where('autopartes_categorias.nombre', $categoria);
        if($marca != '')
            $this->db->where('autopartes_marcas.nombre', $marca);
        if($vehiculo != '')
            $this->db->like('vehiculos.marca', $vehiculo);
        if($linea != '')
            $this->db->like('vehiculos.linea', $linea);
        $this->db->group_by('establecimientos_autopartes.id_autoparte');
        $this->db->where('autopartes.estado', 'Activo');
        $query = $this->db->get('autopartes');
        return $query->result();
    }

    /**
     * Da la lista de vehículos con la relación a la autoparte
     * @return array $vehiculos
     */
    function dar_autopartes_vehiculos(){
        $this->db->select('id_autoparte, marca, linea, vehiculos.id_vehiculo');
        $this->db->join('autopartes_vehiculos', 'autopartes_vehiculos.id_vehiculo = vehiculos.id_vehiculo');
        $this->db->order_by('marca', 'asc');
        $query = $this->db->get('vehiculos');
        return $query->result();
    }

    /**
     * Da las autopartes asociados a una categoría
     * @param int $id_autoparte_categoria
     * @return array $autopartes
     */
    function dar_autopartes_categoria($id_autoparte_categoria){
        $this->db->escape($id_autoparte_categoria);
        $this->db->where('id_autoparte_categoria', $id_autoparte_categoria);
        $query = $this->db->get('autopartes');
        return $query->result();
    }

    /**
     * Da las autopartes asociados a una marca
     * @param int $id_autoparte_marca
     * @return array $autopartes
     */
    function dar_autopartes_marca($id_autoparte_marca){
        $this->db->escape($id_autoparte_marca);
        $this->db->where('id_autoparte_marca', $id_autoparte_marca);
        $query = $this->db->get('autopartes');
        return $query->result();
    }

    /**
     * Da las categorías de las autopartes
     * @return array $categorias
     */
    function dar_autopartes_categorias(){
        $this->db->order_by('nombre', 'asc');
        $query = $this->db->get('autopartes_categorias');
        return $query->result();
    }

   /**
    * Da las categorías de las autopartes según la marca y el vehículo
    * @param String $marca
    * @return array $categorias
    */
    function dar_autopartes_categorias_filtros($marca, $vehiculo, $linea){
        $this->db->escape($marca);
        $this->db->escape($vehiculo);
        $this->db->escape($linea);
        $this->db->select('count(distinct autopartes.id_autoparte) as cantidad, autopartes_categorias.nombre as nombre');
        $this->db->join('autopartes_categorias', 'autopartes.id_autoparte_categoria = autopartes_categorias.id_autoparte_categoria');
        $this->db->where('autopartes.estado', 'Activo');
        if($marca!=''){
            $this->db->join('autopartes_marcas', 'autopartes_marcas.id_autoparte_marca = autopartes.id_autoparte_marca');
            $this->db->where('autopartes_marcas.nombre', $marca);
        }
        if( $vehiculo!= '' || $linea!= '') {
            $this->db->join('autopartes_vehiculos', 'autopartes.id_autoparte = autopartes_vehiculos.id_autoparte');
        }
        if( $vehiculo!= '' && $linea == '' ) {
            $this->db->where("autopartes_vehiculos.id_vehiculo IN (select v.id_vehiculo from vehiculos v where v.marca like '%".$vehiculo."%')");
        }
        else if( $linea!= '' ) {
            $this->db->where("autopartes_vehiculos.id_vehiculo IN (select id_vehiculo from vehiculos where marca like '%".$vehiculo."%' and linea like '%".$linea."%')");
        }
        $this->db->order_by('autopartes_categorias.nombre', 'asc');
        $this->db->group_by('autopartes_categorias.nombre');
        $query = $this->db->get('autopartes');
        return $query->result();
    }

    /**
     * Da las marcas de las autopartes
     * @return array $marcas
     */
    function dar_autopartes_marcas(){
        $this->db->order_by('nombre', 'asc');
        $query = $this->db->get('autopartes_marcas');
        return $query->result();
    }

   /**
    * Da las categorías de las autopartes según la marca
    * @param String $categoria
    * @return array $marcas
    */
    function dar_autopartes_marcas_filtros($categoria, $marca, $vehiculo, $linea){
        $this->db->escape($categoria);
        $this->db->escape($vehiculo);
        $this->db->escape($linea);
        $this->db->select('count(distinct autopartes.id_autoparte) as cantidad, autopartes_marcas.nombre as nombre');
        $this->db->join('autopartes_marcas', 'autopartes.id_autoparte_marca = autopartes_marcas.id_autoparte_marca');
        $this->db->where('autopartes.estado', 'Activo');
        if($categoria!=''){
            $this->db->join('autopartes_categorias', 'autopartes_categorias.id_autoparte_categoria = autopartes.id_autoparte_categoria');
            $this->db->where('autopartes_categorias.nombre', $categoria);
        }
        if($marca!=''){
            $this->db->where("autopartes_marcas.nombre", $marca);
        }
        if( $vehiculo!= '' || $linea!= '') {
            $this->db->join('autopartes_vehiculos', 'autopartes.id_autoparte = autopartes_vehiculos.id_autoparte');
        }
        if( $vehiculo!= '' && $linea == '' ) {
            $this->db->where("autopartes_vehiculos.id_vehiculo IN (select v.id_vehiculo from vehiculos v where v.marca like '%".$vehiculo."%')");
        }
        else if( $linea!= '' ) {
            $this->db->where("autopartes_vehiculos.id_vehiculo IN (select id_vehiculo from vehiculos where marca like '%".$vehiculo."%' and linea like '%".$linea."%')");
        }
        $this->db->order_by('autopartes_marcas.nombre', 'asc');
        $this->db->group_by('autopartes_marcas.nombre');
        $query = $this->db->get('autopartes');
        return $query->result();
    }

    /**
     * Da las autopartes asociados a un vehículo
     * @param int $id_vehiculo
     * @return array $autopartes
     */
    function dar_autopartes_vehiculo($id_vehiculo){
        $this->db->escape($id_vehiculo);
        $this->db->join('autopartes_vehiculos', 'autopartes_vehiculos.id_autoparte = autopartes.id_autoparte');
        $this->db->where('id_vehiculo', $id_vehiculo);
        $query = $this->db->get('autopartes');
        return $query->result();
    }

    /**
     * Elimina una autoparte
     * @param int $id_autoparte
     */
    function eliminar_autoparte($id_autoparte){
        $this->db->escape($id_autoparte);
        $this->db->where('id_autoparte', $id_autoparte);
        $this->db->delete('autopartes');
    }

    /**
     * Elimina una categoria
     * @param int $id_autoparte_categoria
     */
    function eliminar_autoparte_categoria($id_autoparte_categoria){
        $this->db->escape($id_autoparte_categoria);
        $this->db->where('id_autoparte_categoria', $id_autoparte_categoria);
        $this->db->delete('autopartes_categorias');
    }

    /**
     * Pone en null el campo imagen_url e imagen_thumb_url de la tabla autopartes
     * @param int $id_autoparte
     */
    function eliminar_autoparte_imagen($id_autoparte){
        $this->db->escape($id_autoparte);
        $this->db->set('imagen_url', NULL);
        $this->db->set('imagen_thumb_url', NULL);
        $this->db->where('id_autoparte', $id_autoparte);
        $this->db->update('autopartes');
    }

    /**
     * Elimina una marca
     * @param int $id_autoparte_marca
     */
    function eliminar_autoparte_marca($id_autoparte_marca){
        $this->db->escape($id_autoparte_marca);
        $this->db->where('id_autoparte_marca', $id_autoparte_marca);
        $this->db->delete('autopartes_marcas');
    }

    /**
     * Elimina todas las relaciones autopartes_vehiculos de una autoparte
     * @param int $id_autoparte
     */
    function eliminar_autoparte_vehiculos($id_autoparte){
        $this->db->escape($id_autoparte);
        $this->db->where('id_autoparte', $id_autoparte);
        $this->db->delete('autopartes_vehiculos');
    }

    /**
     * Retorna si existen llaves foráneas respecto a una categoría
     * @param int $id_autoparte_categoria
     * @return boolean $existe true si sí existen llaves foráneas (fk)
     */
    function existe_llaves_foraneas_categoria($id_autoparte_categoria){
        $this->db->escape($id_autoparte_categoria);
        $this->db->where('id_autoparte_categoria', $id_autoparte_categoria);
        $query = $this->db->get('autopartes');
        if($query->num_rows()==0)
            return FALSE;
        return TRUE;
    }

    /**
     * Retorna si existen llaves foráneas respecto a una marca
     * @param int $id_autoparte_marca
     * @return boolean $existe true si sí existen llaves foráneas (fk)
     */
    function existe_llaves_foraneas_marca($id_autoparte_marca){
        $this->db->escape($id_autoparte_marca);
        $this->db->where('id_autoparte_marca', $id_autoparte_marca);
        $query = $this->db->get('autopartes');
        if($query->num_rows()==0)
            return FALSE;
        return TRUE;
    }
}