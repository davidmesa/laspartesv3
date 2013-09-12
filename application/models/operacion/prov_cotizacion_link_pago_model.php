<?php

/*
 * Modela la relación proveedor_cotizacion : link de pago
 */
class prov_cotizacion_link_pago_model extends CI_Model
{
    //datos guardados
    var $id;
    var $id_link_pago;
    var $id_proveedor_cotizacion;
    var $item = '';
    var $base = 0;
    var $iva = 0;
    var $valor = 0;
    var $cantidad = 0;

    /**
     * Constructor de la clase oferta link pago
     */
    function __construct() {
        parent::__construct();
    }

    /**
     * inserta un dato
     * @return id
     */
    function insertar() {
        $this->db->insert('op_prov_cotizacion_link_pago', $this);
        $this->id = mysql_insert_id();
        return mysql_insert_id();
    }

    /**
     * inserta un dato
     * @return id
     */
    function dar() {
        $this->db->where('id', $this->id);
        $query = $this->db->get('op_prov_cotizacion_link_pago', 1);
        foreach ($query->row(0) as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
     * da el primer registro que concuerde con los parametros dados
     * @return id
     */
    function dar_por_filtros($params) {
        foreach ($params as $key => $value)
            $this->db->where($key, $value);
        $query = $this->db->get('op_prov_cotizacion_link_pago', 1);
        foreach ($query->row(0) as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
     * dar todos las ordenes de compra
     */
    function dar_todos_filtros($params){
        foreach ($params as $key => $value) {
            $this->db->where($key, $value);
        }
        $query=$this->db->get('op_prov_cotizacion_link_pago');
        return $query->result();
    }

        /**
     * da todos los que concuerden con los parametros dados
     * @return id
     */
    function dar_todos_por_filtros_model($params) {
        $items = array();
        foreach ($params as $key => $value)
            $this->db->where($key, $value);
        $query = $this->db->get('op_prov_cotizacion_link_pago');
        foreach ($query->result() as $row) {
            $item = new prov_cotizacion_link_pago_model();
            foreach ($row as $key => $value) {
                $item->$key = $value;
            }
            $items[] = $item;
        }
        return $items;
    }

    /**
     * actualizar dato
     * @return [type] [description]
     */
    function actualizar() {
        $this->db->update('op_prov_cotizacion_link_pago', $this, array('id' => $this->id));
    }

    /**
     * Elimina registros dado un filtro
     * @return [type] [description]
     */
    function eliminar_por_filtros($params){
        foreach ($params as $key => $value) {
            $this->db->where($key, $value);
        }
        $this->db->delete('op_prov_cotizacion_link_pago');
    }
    
}
?>
