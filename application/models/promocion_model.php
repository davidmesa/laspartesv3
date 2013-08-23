<?php

/**
 * Clase que maneja la BD en donde las consultas se concentra en las tablas
 * autopartes, autopartes_marca, autopartes_categorias, autopartes_vehiculos
 */
class Promocion_model extends CI_Model{

    /**
     * Constructor de la clase Autoparte_model
     */
    function __construct(){
        parent::__construct();
    }
    
    
    function dar_ofertas_categorias_filtros($marca, $linea){
        $this->db->escape($marca);
        $this->db->escape($linea);
        $this->db->select('count(distinct establecimientos_ofertas.id_oferta) as cantidad, servicios_categoria.nombre as nombre');
        $this->db->join('establecimientos_ofertas','establecimientos_ofertas.id_servicios_categoria = servicios_categoria.id_servicios_categoria');
        $this->db->join('oferta','establecimientos_ofertas.id_oferta = oferta.id_oferta');
        if( $marca!= '' && $linea != '' ) {
            $this->db->join('vehiculos', 'vehiculos.id_vehiculo = establecimientos_ofertas.id_vehiculo');
            $this->db->like('marca', $marca);
            $this->db->like('linea', $linea);
        }
        $this->db->where('vigencia >', 'curdate()', FALSE);
        $this->db->order_by('servicios_categoria.nombre', 'asc');
        $this->db->group_by('servicios_categoria.id_servicios_categoria');
        $query = $this->db->get('servicios_categoria');
        return $query->result();
    }
    
    function dar_ofertas_vehiculo($marca, $linea){
        $this->db->escape($marca);
        $this->db->escape($linea);
        $this->db->select('oferta.id_oferta, oferta.titulo as titulo, oferta.precio as precio');
        $this->db->join('oferta','establecimientos_ofertas.id_oferta = oferta.id_oferta');
        if( $marca!= '' && $linea != '' ) {
            $this->db->join('vehiculos', 'vehiculos.id_vehiculo = establecimientos_ofertas.id_vehiculo');
            $this->db->where('marca', $marca);
            $this->db->where('linea', $linea);
        }
        $this->db->where('vigencia >', 'curdate()', FALSE);
        $this->db->group_by('oferta.id_oferta');
        $this->db->order_by('oferta.titulo', 'asc');
        $query = $this->db->get('establecimientos_ofertas');
        return $query->result();
    }
    
    function dar_ofertas_paginacion_filtros($limit, $offset, $orden, $categoria, $marca, $linea){
        $this->db->escape($categoria);
        $this->db->escape($marca);
        $this->db->escape($linea);
        $this->db->escape($limit);
        $this->db->escape($offset);
        $this->db->escape($orden);
        $this->db->select('oferta.id_oferta, oferta.titulo as titulo, oferta.foto as foto, oferta.precio as precio, oferta.iva as iva, oferta.condiciones as condiciones, oferta.incluye as incluye,
            oferta.descripcion as descripcion, oferta.vigencia as vigencia, servicios_categoria.nombre as categoria, oferta.dco_feria, oferta.plazo_uso');
        $this->db->join('oferta','establecimientos_ofertas.id_oferta = oferta.id_oferta');
        $this->db->join('servicios_categoria','establecimientos_ofertas.id_servicios_categoria = servicios_categoria.id_servicios_categoria');
        if($categoria != '')
            $this->db->where('servicios_categoria.nombre', $categoria);
        if( $marca != '' && $linea != '' ) {
                $this->db->join('vehiculos', 'vehiculos.id_vehiculo = establecimientos_ofertas.id_vehiculo');
                $this->db->like('marca', str_replace ("_", " ", $marca));
                $this->db->like('linea', $linea);
        }
        $this->db->where('vigencia >', 'curdate()', FALSE);
        $this->db->group_by('oferta.id_oferta');
        $this->db->limit($limit, $offset*10);
        $this->db->order_by('oferta.id_oferta desc');
        $query = $this->db->get('establecimientos_ofertas');
        return $query->result();
    }
    
    function dar_ofertas_cantidad($categoria, $marca, $linea){ 
        $this->db->escape($categoria);
        $this->db->escape($marca);
        $this->db->escape($linea);
        $this->db->select('oferta.id_oferta, oferta.titulo as titulo, oferta.precio as precio, oferta.iva as iva, oferta.condiciones as condiciones, oferta.incluye as incluye,
            oferta.descripcion as descripcion, oferta.vigencia as vigencia, servicios_categoria.nombre as categoria, oferta.dco_feria, oferta.plazo_uso');
        $this->db->join('oferta','establecimientos_ofertas.id_oferta = oferta.id_oferta');
        $this->db->join('servicios_categoria','establecimientos_ofertas.id_servicios_categoria = servicios_categoria.id_servicios_categoria');
        if($categoria != '')
            $this->db->where('servicios_categoria.nombre', $categoria);
        if( $marca != '' && $linea != '' ) {
                $this->db->join('vehiculos', 'vehiculos.id_vehiculo = establecimientos_ofertas.id_vehiculo');
                $this->db->like('marca', $marca);
                $this->db->like('linea', $linea);
        }
        $this->db->where('vigencia >', 'curdate()', FALSE);
        $this->db->group_by('oferta.id_oferta');
        $query = $this->db->get('establecimientos_ofertas');
        return $query->num_rows();
    } 
    
    function dar_oferta_precio($id_oferta){
        $this->db->escape($id_oferta);
        $this->db->select('precio, iva');
        $this->db->where('id_oferta', $id_oferta);
        $query = $this->db->get('oferta');
        return $query->row(0);
    }
    
    function dar_oferta($id_oferta){
        $this->db->escape($id_oferta);
        $this->db->select('oferta.id_oferta AS id_oferta,  oferta.titulo AS titulo, oferta.foto AS foto, oferta.plazo_uso AS plazo, oferta.margenLP,
                oferta.precio AS precio, oferta.iva AS iva, oferta.dco_feria AS dco_feria,oferta.condiciones AS condiciones, oferta.incluye AS incluye, oferta.descripcion AS descripcion, 
                oferta.vigencia AS vigencia, establecimientos_ofertas.id_establecimiento as id_establecimiento, establecimientos.telefonos AS telefonos,
                establecimientos.nombre as establecimientoNombre, establecimientos.descripcion as establecimientoDescripcion, establecimientos.id_establecimiento,
                establecimientos.direccion as direccion, establecimientos.logo_thumb_url as logo, establecimientos.web AS web,
                count(distinct(establecimientos_comentarios.id_establecimiento_comentario)) as num_comentarios, 
                avg(establecimientos_comentarios.calificacion) as calificacion');
        $this->db->join('oferta','establecimientos_ofertas.id_oferta = oferta.id_oferta');
        $this->db->join('servicios_categoria','establecimientos_ofertas.id_servicios_categoria = servicios_categoria.id_servicios_categoria');
        $this->db->join('establecimientos','establecimientos_ofertas.id_establecimiento = establecimientos.id_establecimiento');
        $this->db->join('establecimientos_comentarios', 'establecimientos_comentarios.id_establecimiento = establecimientos_ofertas.id_establecimiento', 'left');
        $this->db->where('vigencia >', 'curdate()', FALSE);
        $this->db->where('oferta.id_oferta', $id_oferta);
        $this->db->group_by('oferta.id_oferta');
        $query = $this->db->get('establecimientos_ofertas');
        return $query->row(0);
    }
    
    /**
     * Da los vehículos asociados a una autoparte
     * @param int $id_autoparte
     * @return array $vehiculos
     */
    function dar_oferta_vehiculos($id_oferta){
        $this->db->escape($id_oferta);
        $this->db->escape($id_oferta);
        $this->db->select('marca, tipo');
        $this->db->distinct();
        $this->db->join('establecimientos_ofertas', 'establecimientos_ofertas.id_vehiculo = vehiculos.id_vehiculo');
        $this->db->where('id_oferta', $id_oferta);
        $this->db->order_by('marca', 'asc');
        $query = $this->db->get('vehiculos');
        return $query->result();
    }
}