<?php

/**
 * Clase que maneja la BD en donde las consultas se concentra en las tabla indicadores
 */
class Indicador_model extends CI_Model{

    /**
     * Constructor de la clase Noticia_model
     */
    function __construct(){
        parent::__construct();
    }

    /**
     * Actualiza un indicador
     * @param int $id_indicador
     * @param String $nombre
     * @param String $valor
     */
    function actualizar_indicador($id_indicador, $nombre, $valor){
        $this->db->escape($id_indicador);
        $this->db->escape($nombre);
        $this->db->escape($valor);
        $this->db->set('nombre', $nombre);
        $this->db->set('valor', $valor);
        $this->db->where('id_indicador', $id_indicador);
        $this->db->update('indicadores');
    }

    /**
     * Da la lista de indicadores
     * @return array $indicadores
     */
    function dar_indicadores(){
        $query = $this->db->get('indicadores');
        return $query->result();
    }
}