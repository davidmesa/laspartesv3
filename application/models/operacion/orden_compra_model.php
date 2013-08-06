<?php

/*
 * Modela a la orden de compra
 */
class orden_compra_model extends CI_Model
{
    //datos guardados
    var $id;
    var $id_cotizacion;
    var $fecha;
    var $fecha_envio;
    var $autorizado = 'Felipe Pacheco';
    var $proveedor = '';
    var $email_proveedor = '';
    var $dir_proveedor = '';
    var $ciudad_proveedor = '';
    var $tel_proveedor = '';
    var $subtotal;
    var $impuestos_ventas = 0;
    var $otros = 0;
    var $total;
    
    /**
     * Constructor de la clase orden_compra_model
     */
    function __construct() {
        parent::__construct();
    }
    
    /**
     * inserta un dato
     * @return id
     */
    function insertar() {
        $this->db->insert('op_orden_compra', $this);
        $this->id = mysql_insert_id();
        return mysql_insert_id();
    }

    /**
     * inserta un dato
     * @return id
     */
    function dar() {
        $this->db->where('id', $this->id);
        $query = $this->db->get('op_orden_compra', 1);
        foreach ($query->row(0) as $key => $value) {
            $this->$key = $value;
        }
    }

    
}
?>
