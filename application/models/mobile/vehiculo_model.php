<?php

/**
 * Clase que maneja la BD en donde las consultas se concentra en la tabla vehiculos
 */
class Vehiculo_model extends CI_Model {

    /**
     * Constructor de la clase Vehiculo_model
     */
    function __construct() {
        parent::__construct();
    }


    /*
     * Da los datos de un vehiculo
     * @param int $id_vehiculo
     * @return object $vehiculo
     */
    function existe_vehiculo_marca_linea($marca, $linea) {
        $this->db->escape($marca);
        $this->db->escape($linea);
        $this->db->select('vehiculos.*');
        $this->db->where('marca', $marca);
        $this->db->where('linea', $linea);
        $this->db->limit(1);
        $query = $this->db->get('vehiculos');
        if ($query->num_rows() > 0)
            return $query->row(0);
        else
            return false;
    }
    
    
    /**
     * Agrega un nuevo vehículo
     * @param String $marca
     * @param String $linea
     */
    function agregar_vehiculo($marca, $linea) {
        $this->db->escape($marca);
        $this->db->escape($linea);
        $this->db->set('marca', $marca);
        $this->db->set('linea', $linea);
        $this->db->insert('vehiculos');
        return mysql_insert_id();
    }
}