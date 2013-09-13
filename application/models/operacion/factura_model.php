<?php

/*
 * Modela la factura
 */
class factura_model extends CI_Model
{
    //datos guardados
    var $id;
    var $id_consecutivo_factura;
    var $id_pipeline;
    var $url;
    var $anulado = 0;
    
    /**
     * Constructor de la clase factura model
     */
    function __construct() {
        parent::__construct();
    }
    
    /**
     * inserta un dato
     * @return id
     */
    function insertar() {
        $this->db->insert('op_factura', $this);
        $this->id = mysql_insert_id();
        return mysql_insert_id();
    }

    /**
     * inserta un dato
     * @return id
     */
    function dar() {
        $this->db->where('id', $this->id);
        $query = $this->db->get('op_factura', 1);
        foreach ($query->row(0) as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
     * Da el primer registro según el id pipeline
     * @return id
     */
    function dar_por_pipeline() {
        $this->db->where('id_pipeline', $this->id_pipeline);
        $query = $this->db->get('op_factura', 1);
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
        $query=$this->db->get('op_factura');
        return $query->result();
    }

    /**
     * actualizar un dato según filtros
     */
    function actualizar_filtros($id, $params) {
        $this->db->update('op_factura', $params, array('id' => $id));
    }

    /**
     * actualizar dato
     * @return [type] [description]
     */
    function actualizar() {
        $this->db->update('op_factura', $this, array('id' => $this->id));
    }


    
}
?>
