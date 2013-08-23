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
