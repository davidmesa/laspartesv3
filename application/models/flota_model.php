<?php

/**
 * Clase que maneja la BD en donde las consultas se concentra en la tabla usuarios
 */
class Flota_model extends CI_Model {

    /**
     * Constructor de la clase Usuario_model
     */
    function __construct() {
        parent::__construct();
//        $this->db = $this->load->database('default', TRUE);
    }

    /**
     * Da las flotas de un usuario
     * @param  int $id_usuario id del usuario
     * @return list  lista de carros de las flotas
     */
    function dar_flotas_usuario($id_usuario){
        $this->db->escape($id_usuario);
        $this->db->select('flotas.id_flota, flotas.nombre');
        $this->db->join('flota_usuario_vehiculo','flotas.id_flota = flota_usuario_vehiculo.id_flota');
        $this->db->join('usuarios_vehiculos', 
                    'usuarios_vehiculos.id_usuario_vehiculo = flota_usuario_vehiculo.id_usuario_vehiculo');
        $this->db->where('usuarios_vehiculos.id_usuario', $id_usuario);
        $this->db->group_by('flotas.id_flota');
        $query = $this->db->get('flotas');
        return $query->result();
    }

    /**
     * Da los vehiculos de una flota
     * @param  int $id_usuario id del usuario
     * @return list  lista de carros de las flotas
     */
    function dar_vehiculos_flota($id_flota){
        $this->db->escape($id_flota);
        $this->db->join('flota_usuario_vehiculo','flotas.id_flota = flota_usuario_vehiculo.id_flota');
        $this->db->join('usuarios_vehiculos', 
                    'usuarios_vehiculos.id_usuario_vehiculo = flota_usuario_vehiculo.id_usuario_vehiculo');
        $this->db->join('vehiculos', 'vehiculos.id_vehiculo = usuarios_vehiculos.id_vehiculo');
        $this->db->where('flotas.id_flota', $id_flota);
        $query = $this->db->get('flotas');
        return $query->result();
    }

    /**
     * Solicita la lista de tareas para un vehículo
     * @param String id del vehículo
     * @return array $tareas
     */
    function dar_tareas_vehiculo($id_vehiculo, $modelo = '') {
        $this->db->escape($id_vehiculo);
        $this->db->escape($modelo);
        $this->db->select('tareas_servicios.id_tarea AS id_tarea, tareas.nombre AS nombre, inicio, periodicidad, rango,
                    tareas.descripcion AS descripcion, tareas.imagen_thumb_url AS imagen_thumb_url, 
                    tareas.id_servicio as id_servicio');
        $this->db->join('tareas', 'tareas.id_servicio = tareas_servicios.id_servicio');
        $this->db->where('tareas_servicios.id_vehiculo', $id_vehiculo);
        if ($modelo != '')
            $this->db->where('tareas_servicios.modelo', $modelo);
        $query = $this->db->get('tareas_servicios');

        return $query->result();

    }

    /**
     * Solicita la lista de tareas personalizadas de un vehículo
     * @param String id del vehículo
     * @return array $tareas
     */
    function dar_tareas_vehiculo_personalizado($id_usuario_vehiculo) {
        $this->db->escape($id_usuario_vehiculo);
        $this->db->select('flotas_hmto.id_tarea, tareas.nombre AS nombre, periodicidad, rango,
                    tareas.descripcion AS descripcion, tareas.imagen_thumb_url AS imagen_thumb_url, 
                    tareas.id_servicio');
        $this->db->join('tareas', 'tareas.id_servicio = flotas_hmto.id_tarea');
        $this->db->join('flota_usuario_vehiculo', 'flota_usuario_vehiculo.id_flota_usuario_vehiculo = flotas_hmto.id_flota_usuario_vehiculo');
        $this->db->where('flota_usuario_vehiculo.id_usuario_vehiculo', $id_usuario_vehiculo);
        $query = $this->db->get('flotas_hmto');

        return $query->result();
    }

    /**
     * Da las categorias menores a 32, diferentes a 9 y a 10 y las que son personalizadas para la flota
     * @param  int $id_flota
     * @return array categorias
     */
    function dar_tareas_categoria($id_flota){
        $this->db->escape($id_flota);
        $this->db->select('tareas.*');
        $this->db->join('flota_usuario_vehiculo', 'flota_usuario_vehiculo.id_flota = flotas.id_flota');
        $this->db->join('flotas_hmto', 'flotas_hmto.id_flota_usuario_vehiculo = flota_usuario_vehiculo.id_flota_usuario_vehiculo');
        $this->db->join('tareas', 'tareas.id_servicio = flotas_hmto.id_tarea');
        $this->db->where('flotas.id_flota', $id_flota);
        $this->db->group_by('tareas.id_servicio');
        $query = $this->db->get('flotas');
        $subQuery1 = $this->db->last_query();
        $this->db->_reset_select();

        $this->db->from('tareas');
        $this->db->where('id_servicio != ','9');
        $this->db->where('id_servicio != ','10');
        $this->db->where('id_servicio <= ','32');
        $query = $this->db->get();
        $subQuery2 = $this->db->last_query();
        $this->db->_reset_select();

        $q = $this->db->query("select * from ($subQuery1 UNION $subQuery2) as unionTable");
        // $this->db->from("($subQuery1 UNION $subQuery2)");
        // $q = $this->db->get();
        return $q->result();
    }

    /**
     * Da la flota correspondiente a un vehículo
     * @param  int $id_usuario_vehiculo
     * @return array flota
     */
    function dar_flota_segun_vehiculo($id_usuario_vehiculo){
        $this->db->escape($id_usuario_vehiculo);
        $this->db->join('flota_usuario_vehiculo', 'flotas.id_flota = flota_usuario_vehiculo.id_flota');
        $this->db->where('id_usuario_vehiculo',$id_usuario_vehiculo);
        $q = $this->db->get('flotas');
        return $q->row(0);
    }

    /**
     * Da el flota usuario vehiculo
     * @param  int $id_usuario_vehiculo 
     * @return array flota usuario vehiculo 
     */
    function dar_flota_vehiculo($id_usuario_vehiculo){
        $this->db->escape($id_usuario_vehiculo);
        $this->db->where('id_usuario_vehiculo', $id_usuario_vehiculo);
        $this->db->limit(1);
        $q = $this->db->get('flota_usuario_vehiculo');
        return $q->row(0);
    }

    /**
     * Agrega un vehículo a una flota
     * @param  int $id_usuario_vehiculo 
     * @return int el id de la flota vehiculo
     */
    function agregar_flota_vehiculo($id_usuario_vehiculo, $id_flota){
        $this->db->escape($id_usuario_vehiculo);
        $this->db->set('id_usuario_vehiculo', $id_usuario_vehiculo);
        $this->db->set('id_flota', $id_flota);
        $this->db->insert('flota_usuario_vehiculo');
        return mysql_insert_id();
    }

   
    /**
     * Borra la hmto de un vehículo dado
     * @param  int $usuario_vehiculo id_usuario_vehiculo
     */
    function borrar_hmto_usuario_vehiculo($usuario_vehiculo){
        $this->db->escape($usuario_vehiculo);
        $this->db->where('flotas_hmto.id_flota_usuario_vehiculo in 
            (select fuv.id_flota_usuario_vehiculo from flota_usuario_vehiculo as fuv where fuv.id_usuario_vehiculo = '.$usuario_vehiculo.') ');
        $this->db->delete('flotas_hmto');
    }

    /**
     * Agregar la hoja de mantenimiento de un carro
     * @param  int $id_flota_vehiculo id flota vehículo
     * @param  int $id_servicio id de la tarea
     * @param  periodicidad $periodicidad  periodicidad
     * @param  int $rango  rango
     */
    function agregar_hoja_mto($id_flota_vehiculo, $id_servicio, $periodicidad, $rango){
        $this->db->escape($id_servicio);
        $this->db->escape($periodicidad);
        $this->db->escape($rango);
        $this->db->escape($modelo);
        $this->db->escape($id_usuario_vehiculo);
        $this->db->set('id_flota_usuario_vehiculo', $id_flota_vehiculo);
        $this->db->set('id_tarea', $id_servicio);
        $this->db->set('periodicidad', $periodicidad);
        $this->db->set('rango', $rango);
        $this->db->insert('flotas_hmto');
    }

    /**
     * Asigna una tarea
     * @param  [type] $asignar  [description]
     * @param  [type] $asignado [description]
     * @param  [type] $tarea    [description]
     * @return [type]           [description]
     */
    function asignar_htmo($asignado, $tareas){
        $this->db->escape($asignar);
        $this->db->escape($asignado);
        $this->borrar_hmto_usuario_vehiculo($asignado);
        $id_flota_usuario_vehiculo = $this->dar_flota_vehiculo($asignado)->id_flota_usuario_vehiculo;
        // $this->db->select()
        // $this->db->from('flotas_hmto');
        // $this->db->join('flota_usuario_vehiculo', 'flota_usuario_vehiculo.id_flota_usuario_vehiculo = flotas_hmto.id_flota_usuario_vehiculo');
        // $this->db->where('flotas_hmto.id_usuario_vehiculo', $asignado);
        foreach ($tareas as $key => $tarea) {
            $this->db->set('id_tarea', $tarea->id_servicio);
            $this->db->set('periodicidad', $tarea->periodicidad);
            $this->db->set('rango', $tarea->rango);
            $this->db->set('id_flota_usuario_vehiculo', $id_flota_usuario_vehiculo);
            $this->db->insert('flotas_hmto');
        }
        
        

    }
}