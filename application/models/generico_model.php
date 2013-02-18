<?php

/**
 * Clase que maneja consultas genéricas a la BD
 */
class Generico_model extends CI_Model{

    /**
     * Constructor de la clase Generico_model
     */
    function __construct(){
        parent::__construct();
    }

    /**
     * Da la palabra con tildes de un campo de una tabla
     * @param String $tabla
     * @param String $campo
     * @param String $valor
     * @return String $palabra
     */
    function dar_tildes($tabla, $campo, $valor){
        $this->db->escape($tabla);
        $this->db->escape($campo);
        $this->db->escape($valor);
        if($valor!='')
        $this->db->where($campo, $valor);
        $this->db->limit(1);
        $query = $this->db->get($tabla);
        return $query->row(0);
    }
    
    /**
     * Da los registros de una tabla dada
     * @param String $tabla
     * @return String $palabra
     */
    function dar_registros($tabla){
        $this->db->escape($tabla);
        return $this->db->get($tabla)->result();
    }
    
    /**
     * Da los registros de una tabla dada según parametros dados
     * @param type $tabla
     * @param type $select
     * @param type $where
     * @param type $order
     * @param type $group
     * @param type $limit
     * @return resulset de registros
     */
    function dar_registros_genericos($tabla, $select, $where, $order, $group, $limit){
        $this->db->escape($tabla);
        $this->db->escape($select);
        $this->db->escape($order);
        $this->db->escape($where);
        $this->db->escape($group);
        $this->db->escape($limit);
        
        //para el caso de select
        if(sizeof($select)!=0){
            foreach ($select as $temp_select):
                $this->db->select($temp_select);
            endforeach;
        }
        
        //para el caso de where
        if(sizeof($where)!=0){
            foreach ($where as $temp_where):
                $this->db->where($temp_where[0], $temp_where[1]);
            endforeach;
        }
        
        //para el caso del order
        if(sizeof($order)!=0){
                $this->db->order_by($order[0], $order[1]);
        }
        
        //para el caso del group by
        if(isset($group)){
                $this->db->group_by($group);
        }
        
        //para el caso del limit
        if(isset($limit) && is_numeric($limit)){
                $this->db->limit($limit);
        }
        
        return $this->db->get($tabla)->result();
    }
    
    /**
     * Actualiza los registros de una tabla dada según parametros dados
     * @param type $tabla
     * @param type $set
     * @param type $where 
     */
    function actualizar_registros_genericos($tabla, $set, $where){
        $this->db->escape($tabla);
        $this->db->escape($set);
        $this->db->escape($where);
        
        //para el caso de set
        if(sizeof($set)!=0){
            foreach ($set as $temp_set):
                $this->db->set($temp_set[0], $temp_set[1]);
            endforeach;
        }
        //para el caso de where
        if(sizeof($where)!=0){
            foreach ($where as $temp_where):
                $this->db->where($temp_where[0], $temp_where[1]);
            endforeach;
        }
        
        $this->db->update($tabla);
    }
    
    /**
     *Guarda los registros de una tabla dada según parametros dados
     * @param type $tabla
     * @param type $set 
     */
    function agreagar_registros_genericos($tabla, $set ){
        $this->db->escape($tabla);
        $this->db->escape($set);
        
        
        //para el caso de set
        if(sizeof($set)!=0){
            foreach ($set as $temp_set):
                $this->db->set($temp_set[0], $temp_set[1]);
            endforeach;
        }
        
        $this->db->insert($tabla);
        return mysql_insert_id();
    }
    

    
   /**
     *Guarda los registros de una tabla dada según parametros dados
     * @param type $tabla
     * @param type $set 
     */
    function eliminar_registros_genericos($tabla, $where ){
        $this->db->escape($tabla);
        $this->db->escape($where);
        
        
        //para el caso de where
        if(sizeof($where)!=0){
            foreach ($where as $temp_where):
                $this->db->where($temp_where[0], $temp_where[1]);
            endforeach;
        }
        
        $this->db->insert($tabla);
    }
    
}
