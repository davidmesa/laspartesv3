<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */



class proveedor_model extends CI_Model
{
    //datos guardados
    var $id;
    var $proveedor;
    var $email;
    var $direccion = '';
    var $ciudad = '';
    var $telefono = '';
    
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
        $this->db->insert('op_proveedores', $this);
        $this->id = mysql_insert_id();
        return mysql_insert_id();
    }

    /**
     * actualizar dato
     * @return [type] [description]
     */
    function actualizar() {
        $this->db->update('op_proveedores', $this, array('id' => $this->id));
    }

    /**
     * inserta un dato
     */
    function dar() {
        $this->db->where('id', $this->id);
        $query = $this->db->get('op_proveedores', 1);
        foreach ($query->row(0) as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
     * Dado un id se actualiza el modelo, si no existe inserta la tupla
     */
    function replace(){
        $query = 'REPLACE INTO op_proveedores (id, proveedor, email, direccion, ciudad, telefono) VALUES (?, ?, ?, ?, ?, ?)';
        $this->db->query($query, array($id, $email, $direccion, $ciudad, $telefono));
    }

    /**
     * da el primer registro que concuerde con los parametros dados
     * @return id
     */
    function dar_por_filtros($params) {
        foreach ($params as $key => $value)
            $this->db->where($key, $value);
        $query = $this->db->get('op_proveedores', 1);
        foreach ($query->row(0) as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
     * dar todos los proveedores
     */
    function dar_todos(){
        $query=$this->db->get('op_proveedores');
        return $query->result();
    }
}
?>
