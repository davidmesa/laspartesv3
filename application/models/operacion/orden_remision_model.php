<?php

/*
 * Modela a la orden de compra
 */
class orden_remision_model extends CI_Model
{
    //datos guardados
    var $id;
    var $id_bono;
    var $id_pipeline;
    
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
        $this->db->insert('op_orden_remision', $this);
        $this->id = mysql_insert_id();
        return mysql_insert_id();
    }

    /**
     * actualizar dato
     */
    function actualizar() {
        $this->db->update('op_orden_remision', $this, array('id' => $this->id));
    }

    /**
     * actualizar un dato según filtros
     */
    function actualizar_filtros($id, $params) {
        $this->db->update('op_orden_remision', $params, array('id' => $id));
    }

    /**
     * inserta un dato
     * @return id
     */
    function dar() {
        $this->db->where('id', $this->id);
        $query = $this->db->get('op_orden_remision', 1);
        foreach ($query->row(0) as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
     * dar todos las ordenes de compra
     */
    function dar_todos(){
        $query=$this->db->get('op_orden_remision');
        return $query->result();
    }

    /**
     * dar todos las ordenes de compra
     */
    function dar_todos_filtros($params){
        foreach ($params as $key => $value) {
            $this->db->where($key, $value);
        }
        $query=$this->db->get('op_orden_remision');
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
        $query = $this->db->get('op_orden_remision');
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
