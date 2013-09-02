<?php

/*
 * Modela drop box model
 */
class usuarios_dropbox_model extends CI_Model
{
    //datos guardados
    var $id;
    var $id_usuario;
    var $oauth_token = '';
    var $oauth_token_secret = '';
    
    /**
     * Constructor de la clase drop box model
     */
    function __construct() {
        parent::__construct();
    }
    
    /**
     * inserta un dato
     * @return id
     */
    function insertar() {
        $this->db->insert('usuarios_dropbox', $this);
        $this->id = mysql_insert_id();
        return mysql_insert_id();
    }

    /**
     * inserta un dato
     * @return id
     */
    function dar() {
        $this->db->where('id', $this->id);
        $query = $this->db->get('usuarios_dropbox', 1);
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
        $query=$this->db->get('usuarios_dropbox');
        return $query->result();
    }

    /**
     * da el primer registro que concuerde con los parametros dados
     * @return id
     */
    function dar_por_filtros($params) {
        foreach ($params as $key => $value)
            $this->db->where($key, $value);
        $query = $this->db->get('usuarios_dropbox', 1);
        foreach ($query->row(0) as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
     * actualizar dato
     * @return [type] [description]
     */
    function actualizar() {
        $this->db->update('usuarios_dropbox', $this, array('id' => $this->id));
    }


    
}
?>
