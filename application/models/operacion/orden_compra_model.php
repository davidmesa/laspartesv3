<?php

/*
 * Modela a la orden de compra
 */
class orden_compra_model extends CI_Model
{
    //datos guardados
    var $id;
    var $id_cotizacion;
    var $url = '';
    var $fecha;
    var $fecha_envio;
    var $autorizado = 'Felipe Pacheco';
    var $id_proveedor;
    var $proveedor = '';
    var $email_proveedor = '';
    var $dir_proveedor = '';
    var $ciudad_proveedor = '';
    var $tel_proveedor = '';
    var $subtotal;
    var $impuestos_ventas = 0;
    var $otros = 0;
    var $total;
    var $anulado = 0;
    
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
     * actualizar dato
     */
    function actualizar() {
        $this->db->update('op_orden_compra', $this, array('id' => $this->id));
    }

    /**
     * actualizar un dato según filtros
     */
    function actualizar_filtros($id, $params) {
        $this->db->update('op_orden_compra', $params, array('id' => $id));
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

    /**
     * dar todos las ordenes de compra
     */
    function dar_todos(){
        $query=$this->db->get('op_orden_compra');
        return $query->result();
    }


    /**
     * da todos los que concuerden con los parametros dados
     * @return id
     */
    function dar_todos_por_filtros($params) {
        $items = array();
        foreach ($params as $key => $value)
            $this->db->where($key, $value);
        $query = $this->db->get('op_orden_compra');
        foreach ($query->result() as $row) {
            $item = new orden_compra_model();
            foreach ($row as $key => $value) {
                $item->$key = $value;
            }
            $items[] = $item;
        }
        return $items;
    }

    
}
?>
