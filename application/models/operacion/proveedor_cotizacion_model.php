<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */



class proveedor_cotizacion_model extends CI_Model
{
    //datos guardados
    var $id;
    var $id_item_cotizacion;
    var $id_proveedor;
    var $lp_valor;
    var $iva;
    var $nota = '';
    var $elegido = 0;

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
        $this->db->insert('op_proveedor_cotizacion', $this);
        $this->id = mysql_insert_id();
        return mysql_insert_id();
    }

    /**
     * actualizar dato
     * @return [type] [description]
     */
    function actualizar() {
        $this->db->update('op_proveedor_cotizacion', $this, array('id' => $this->id));
    }

    /**
     * inserta un dato
     * @return id
     */
    function dar() {
        $this->db->where('id', $this->id);
        $query = $this->db->get('op_proveedor_cotizacion', 1);
        foreach ($query->row(0) as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
     * da los items relacionados con el proveedor cotizacion
     * @return array[op_item_cotizacion] 
     */
    function dar_item_cotizacion() {
        $CI =& get_instance();
        $CI->load->model('operacion/item_cotizacion_model');
        $this->db->select('op_item_cotizacion.*');
        $this->db->join('op_item_cotizacion', 
            'op_item_cotizacion.id = op_proveedor_cotizacion.id_item_cotizacion');
        $this->db->where('op_proveedor_cotizacion.id_item_cotizacion', $this->id_item_cotizacion);
        $query = $this->db->get('op_proveedor_cotizacion');
        $row = $query->row(0);
        $item = new item_cotizacion_model();
        foreach ($row as $key => $value)
            $item->$key = $value;
        return $item;
    }

    /**
     * da el proovedor seleccionado
     * @return array[proveedor_cotizacion_model] 
     */
    function dar_proveedor() {
        $CI =& get_instance();
        $CI->load->model('operacion/proveedor_model');
        $this->db->select('op_proveedores.*');
        $this->db->join('op_proveedores', 
            'op_proveedor_cotizacion.id_proveedor = op_proveedores.id');
        $this->db->where('op_proveedor_cotizacion.id', $this->id);
        $query = $this->db->get('op_proveedor_cotizacion', 1);
        $row = $query->row(0);
        $item = new proveedor_model();
        foreach ($row as $key => $value) {
            $item->$key = $value;
        }
        return $item;
    }
}
?>
