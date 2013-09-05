<?php

/*
 * Modela a cotización model
 */
class link_pago_model extends CI_Model
{
    //datos guardados
    var $id;
    var $id_pipeline;
    var $id_usuario;
    var $id_oferta;
    var $url = '';

    /**
     * Constructor de la clase link de pago
     */
    function __construct() {
        parent::__construct();
    }

    /**
     * inserta un dato
     * @return id
     */
    function insertar() {
        $this->db->insert('op_link_pago', $this);
        $this->id = mysql_insert_id();
        return mysql_insert_id();
    }

    /**
     * inserta un dato
     * @return id
     */
    function dar() {
        $this->db->where('id', $this->id);
        $query = $this->db->get('op_link_pago', 1);
        foreach ($query->row(0) as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
     * da un dato según la oferta
     * @return id
     */
    function dar_por_oferta() {
        $this->db->where('id_oferta', $this->id_oferta);
        $query = $this->db->get('op_link_pago', 1);
        foreach ($query->row(0) as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
     * actualizar dato
     * @return [type] [description]
     */
    function actualizar() {
        $this->db->update('op_link_pago', $this, array('id' => $this->id));
    }

    /**
     * dar todos las ordenes de compra
     */
    function dar_todos(){
        $query=$this->db->get('op_link_pago');
        return $query->result();
    }

    /**
     * dar todos las ordenes de compra
     */
    function dar_todos_filtros($params){
        foreach ($params as $key => $value) {
            $this->db->where($key, $value);
        }
        $query=$this->db->get('op_link_pago');
        return $query->result();
    }

    /**
     * Elimina registros dado el id
     * @return [type] [description]
     */
    function eliminar($params){
        $this->db->delete('op_link_pago', array('id'=>$this->id));
    }
    
}
?>
