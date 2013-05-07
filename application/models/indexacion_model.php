<?php

/**
 * Clase que maneja la BD en donde las consultas se concentra en la tabla de indexacion
 */
class Indexacion_model extends CI_Model{

    /**
     * Constructor de la clase Indexacion_model
     */
    function __construct(){
        parent::__construct();
    }

    /**
     * Agrega una nueva indexación
     * @param String $seccion
     * @param int $id_seccion
     * @param String $titulo
     * @param String $resumen
     * @param String $indexacion
     * @param String $url
     * @param String $estado
     */
    function agregar_indexacion($seccion, $id_seccion, $titulo, $resumen, $indexacion, $url, $estado){
        $this->db->escape($seccion);
        $this->db->escape($id_seccion);
        $this->db->escape($titulo);
        $this->db->escape($resumen);
        $this->db->escape($resumen);
        $this->db->escape($estado);
        $this->db->set('seccion', $seccion);
        $this->db->set('id_seccion', $id_seccion);
        $this->db->set('titulo', $titulo);
        $this->db->set('resumen', $resumen);
        $this->db->set('indexacion', $indexacion);
        $this->db->set('url', $url);
        $this->db->set('estado', $estado);
        $this->db->insert('indexaciones');
    }

    /**
     * Actualiza una indexación
     * @param String $seccion
     * @param int $id_seccion
     * @param String $titulo
     * @param String $resumen
     * @param String $indexacion
     * @param String $url
     * @param String $estado
     */
    function actualizar_indexacion($seccion, $id_seccion, $titulo, $resumen, $indexacion, $url, $estado){
        $this->db->escape($seccion);
        $this->db->escape($id_seccion);
        $this->db->escape($titulo);
        $this->db->escape($resumen);
        $this->db->escape($resumen);
        $this->db->escape($estado);
        $this->db->set('titulo', $titulo);
        $this->db->set('resumen', $resumen);
        $this->db->set('indexacion', $indexacion);
        $this->db->set('url', $url);
        $this->db->set('estado', $estado);
        $this->db->where('seccion', $seccion);
        $this->db->where('id_seccion', $id_seccion);
        $this->db->update('indexaciones');
    }

    /**
     * Cuenta los resultados en la sección aprende
     * @param String $busqueda
     * @return int $numero_resultados
     */
    function contar_resultados_aprende($busqueda){
        $this->db->escape($busqueda);
        $this->db->where('seccion="noticias" OR seccion="tips" OR seccion="tutoriales"', NULL, FALSE);
        $this->db->where('MATCH (indexacion) AGAINST ("'.$busqueda.'" in boolean mode)', NULL, FALSE);
        $query = $this->db->get('indexaciones');
        return $query->num_rows();
    }

    /**
     * Cuenta los resultados en la sección autopartes
     * @param String $busqueda
     * @return int $numero_resultados
     */
    function contar_resultados_autopartes($busqueda){
        $this->db->escape($busqueda);
        $this->db->where('seccion', 'autopartes');
        $this->db->where('MATCH (indexacion) AGAINST ("'.$busqueda.'" in boolean mode)', NULL, FALSE);
        $query = $this->db->get('indexaciones');
        return $query->num_rows();
    }

    /**
     * Cuenta los resultados en la sección establecimientos
     * @param String $busqueda
     * @return int $numero_resultados
     */
    function contar_resultados_establecimientos($busqueda){
        $this->db->escape($busqueda);
        $this->db->where('seccion', 'establecimientos');
        $this->db->where('MATCH (indexacion) AGAINST ("'.$busqueda.'" in boolean mode)', NULL, FALSE);
        $query = $this->db->get('indexaciones');
        return $query->num_rows();
    }

    /**
     * Cuenta los resultados de todas las secciones
     * @param String $busqueda
     * @return int $numero_resultados
     */
    function contar_resultados_general($busqueda){
        $this->db->escape($busqueda);
        $this->db->where('MATCH (indexacion) AGAINST ("'.$busqueda.'" in boolean mode)', NULL, FALSE);
        $query = $this->db->get('indexaciones');
        return $query->num_rows();
    }

    /**
     * Cuenta los resultados en la sección taller_en_linea
     * @param String $busqueda
     * @return int $numero_resultados
     */
    function contar_resultados_taller_en_linea($busqueda){
        $this->db->escape($busqueda);
        $this->db->where('seccion', 'taller en línea');
        $this->db->where('MATCH (indexacion) AGAINST ("'.$busqueda.'" in boolean mode)', NULL, FALSE);
        $query = $this->db->get('indexaciones');
        return $query->num_rows();
    }

    /**
     * Muestra las indexaciones de aprende según las palabras dadas
     * @param String $busqueda
     * @param int $limit
     * @param int $offset
     * @return array $resultados
     */
    function dar_indexacion_aprende($busqueda, $limit, $offset){
        $this->db->escape($busqueda);
        $this->db->where('(seccion="noticias" OR seccion="tips" OR seccion="tutoriales") AND (MATCH (indexacion) AGAINST ("'.$busqueda.'" in boolean mode))', NULL, FALSE);
        $this->db->limit($limit, $offset);
        $query = $this->db->get('indexaciones');
        return $query->result();
    }

    /**
     * Muestra las indexaciones de autopartes según las palabras dadas
     * @param String $busqueda
     * @param int $limit
     * @param int $offset
     * @return array $resultados
     */
    function dar_indexacion_autopartes($busqueda, $limit, $offset){
        $this->db->escape($busqueda);
        $this->db->where('seccion', 'autopartes');
        $this->db->where('MATCH (indexacion) AGAINST ("'.$busqueda.'" in boolean mode)', NULL, FALSE);
        $this->db->limit($limit, $offset);
        $query = $this->db->get('indexaciones');
        return $query->result();
    }

    /**
     * Muestra las indexaciones de establecimientos según las palabras dadas
     * @param String $busqueda
     * @param int $limit
     * @param int $offset
     * @return array $resultados
     */
    function dar_indexacion_establecimientos($busqueda, $limit, $offset){
        $this->db->escape($busqueda);
        $this->db->where('seccion', 'establecimientos');
        $this->db->where('MATCH (indexacion) AGAINST ("'.$busqueda.'" in boolean mode)', NULL, FALSE);
        $this->db->limit($limit, $offset);
        $query = $this->db->get('indexaciones');
        return $query->result();
    }

    /**
     * Muestra las indexaciones según las palabras dadas
     * @param String $busqueda
     * @param int $limit
     * @param int $offset
     * @return array $resultados
     */
    function dar_indexacion_general($busqueda, $limit, $offset){
        $this->db->escape($busqueda);
        $this->db->where("MATCH (indexacion) AGAINST ('".$busqueda."' in boolean mode)", NULL, FALSE);
        $this->db->limit($limit, $offset*10);
        $query = $this->db->get('indexaciones');
        return $query->result();
    }

    /**
     * Muestra las indexaciones de noticias según las palabras dadas
     * @param String $busqueda
     * @param int $limit
     * @param int $offset
     * @return array $resultados
     */
    function dar_indexacion_taller_en_linea($busqueda, $limit, $offset){
        $this->db->escape($busqueda);
        $this->db->where('seccion', 'taller en línea');
        $this->db->where('MATCH (indexacion) AGAINST ("'.$busqueda.'" in boolean mode)', NULL, FALSE);
        $this->db->limit($limit, $offset);
        $query = $this->db->get('indexaciones');
        return $query->result();
    }
}