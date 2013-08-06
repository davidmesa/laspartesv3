<?php

/*
 * Modela al item de la orden de compra
 */
class item_orden_compra_model extends CI_Model
{
    //datos guardados
    var $id;
    var $id_orden_compra;
    var $item;
    var $descripcion = NULL;
    var $cantidad;
    var $precio_unidad;
    var $precio_total;
    
    /**
     * Constructor de la clase item_orden_compra model
     */
    function __construct() {
        parent::__construct();
    }
    
    /**
     * inserta un dato
     * @return id
     */
    function insertar() {
        $this->db->insert('op_item_orden_compra', $this);
        $this->id = mysql_insert_id();
        return mysql_insert_id();
    }

    /**
     * inserta un dato
     * @return id
     */
    function dar() {
        $this->db->where('id', $this->id);
        $query = $this->db->get('op_item_orden_compra', 1);
        foreach ($query->row(0) as $key => $value) {
            $this->$key = $value;
        }
    }

    
}
?>
