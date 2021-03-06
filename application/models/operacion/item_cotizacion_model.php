<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */



class item_cotizacion_model extends CI_Model
{
    //datos guardados
    var $id;
    var $id_cotizacion;
    var $item;
    var $cantidad = 0;
    var $margen = 0;
    var $dco = 0;
    var $precio_sin_dco = 0;
    var $precio = 0;
    var $iva = 16;
    var $valido = 0;
    var $id_orden_compra = 0;
    
     /**
     * Constructor de la clase Cotizacion model
     */
    function __construct() {
        parent::__construct();
    }

    /**
     * inserta un dato
     * @return id
     */
    function insertar() {
        $this->db->insert('op_item_cotizacion', $this);
        $this->id = mysql_insert_id();
        return mysql_insert_id();
    }

    /**
     * actualizar dato
     * @return [type] [description]
     */
    function actualizar() {
        $this->db->update('op_item_cotizacion', $this, array('id' => $this->id));
    }

    /**
     * inserta un dato
     * @return id
     */
    function dar() {
        $this->db->where('id', $this->id);
        $query = $this->db->get('op_item_cotizacion', 1);
        foreach ($query->row(0) as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
     * da todos los que concuerden con los parametros dados
     * @return id
     */
    function dar_todos_por_filtros($params) {
        $items = array();
        foreach ($params as $key => $value)
            $this->db->where($key, $value);
        $query = $this->db->get('op_item_cotizacion');
        foreach ($query->result() as $row) {
            $item = new item_cotizacion_model();
            foreach ($row as $key => $value) {
                $item->$key = $value;
            }
            $items[] = $item;
        }
        return $items;
    }

    /**
     * da los proveedores relacionados con el item
     * @return array[proveedor_cotizacion_model] 
     */
    function dar_proveedores_cotizacion() {
        $CI =& get_instance();
        $CI->load->model('operacion/proveedor_cotizacion_model');
        $items = array();
        $this->db->select('op_proveedor_cotizacion.*');
        $this->db->join('op_proveedor_cotizacion', 
            'op_item_cotizacion.id = op_proveedor_cotizacion.id_item_cotizacion');
        $this->db->where('op_item_cotizacion.id', $this->id);
        $query = $this->db->get('op_item_cotizacion');
        foreach ($query->result() as $row) {
            $item = new proveedor_cotizacion_model();
            foreach ($row as $key => $value) {
                $item->$key = $value;
            }
            $items[] = $item;
        }
        return $items;
    }
}
?>
