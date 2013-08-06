<?php

/*
 * Modela a cotización
 */
class cotizacion_model extends CI_Model
{
    //datos guardados
    var $id;
    var $id_usuario;
    var $id_pipeline;
    var $costo;
    var $lp_iva;
    var $lp_valor;
    var $cliente_iva;
    var $cliente_precio;
    var $ganancia;
    var $cree = 0;
    var $ica = 0;
    var $retefuente = 0;
    var $fecha_actualizacion;
    var $fecha_creacion;
    var $eliminado = 0;
    
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
        $this->db->insert('op_cotizacion', $this);
        $this->id = mysql_insert_id();
        return mysql_insert_id();
    }

    /**
     * inserta un dato
     * @return id
     */
    function dar() {
        $this->db->where('id', $this->id);
        $query = $this->db->get('op_cotizacion', 1);
        foreach ($query->row(0) as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
     * inserta un dato
     * @return id
     */
    function dar_por_pipeline() {
        $this->db->where('id_pipeline', $this->id_pipeline);
        $query = $this->db->get('op_cotizacion', 1);
        foreach ($query->row(0) as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
     * actualizar dato
     * @return [type] [description]
     */
    function actualizar() {
        $this->db->update('op_cotizacion', $this, array('id' => $this->id));
    }


    /**
     * da los items relacionados con la cotización
     * @return array[item_cotizacion_model] 
     */
    function dar_items_cotizacion() {
        $CI =& get_instance();
        $CI->load->model('operacion/item_cotizacion_model');
        $items = array();
        $this->db->select('op_item_cotizacion.*');
        $this->db->join('op_item_cotizacion', 'op_item_cotizacion.id_cotizacion = op_cotizacion.id');
        $this->db->where('op_cotizacion.id', $this->id);
        $query = $this->db->get('op_cotizacion');
        foreach ($query->result() as $row) {
            $item = new item_cotizacion_model();
            foreach ($row as $key => $value) {
                $item->$key = $value;
            }
            $items[] = $item;
        }
        return $items;
    }
    
}
?>
