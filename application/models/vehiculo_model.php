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
//        $this->db = $this->load->database('default', TRUE);
    }

    /**
     * Actualiza un vehiculo
     * @param int $id_vehiculo
     * @param String $marca
     * @param String $linea
     */
    function actualizar_vehiculo($id_vehiculo, $marca, $linea) {
        $this->db->escape($id_vehiculo);
        $this->db->escape($marca);
        $this->db->escape($linea);
        $this->db->set('marca', $marca);
        $this->db->set('linea', $linea);
        $this->db->where('id_vehiculo', $id_vehiculo);
        $this->db->limit(1);
        $this->db->update('vehiculos');
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

    /**
     * Da la lista de vehículos
     * @return array $vehiculos
     */
    function dar_vehiculos() {
        $this->db->order_by('marca', 'asc');
        $query = $this->db->get('vehiculos');
        return $query->result();
    }

    /**
     * Da la lista de vehículos
     * @return array $vehiculos
     */
    function dar_vehiculos_marca() {
        $this->db->select('marca');
        $this->db->distinct();
        $this->db->order_by('marca', 'asc');
        $query = $this->db->get('vehiculos');
        return $query->result();
    }

    /**
     * Da la lista de vehículos
     * @return array $vehiculos
     */
    function dar_lineas_vehiculos_marca($marca) {
        $this->db->escape($marca);
        $this->db->select('linea');
        $this->db->distinct();
        $this->db->like('marca', $marca);
        $this->db->order_by('linea', 'asc');
        $query = $this->db->get('vehiculos');
        return $query->result();
    }

    /**
     * Da los datos de un vehiculo
     * @param int $id_vehiculo
     * @return object $vehiculo
     */
    function dar_vehiculo($id_vehiculo) {
        $this->db->escape($id_vehiculo);
        $this->db->where('id_vehiculo', $id_vehiculo);
        $this->db->limit(1);
        $query = $this->db->get('vehiculos');
        return $query->row(0);
    }

    /**
     * Da los datos de un vehiculo
     * @param int $id_vehiculo
     * @return object $vehiculo
     */
    function existe_vehiculo($id_vehiculo) {
        $this->db->escape($id_vehiculo);
        $this->db->where('id_vehiculo', $id_vehiculo);
        $this->db->limit(1);
        $query = $this->db->get('vehiculos');
        if ($query->num_rows() != 0)
            return true;
        else
            return false;
    }

    /**
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
     * Elimina un vehiculo
     * @param int $id_vehiculo
     */
    function eliminar_vehiculo($id_vehiculo) {
        $this->db->escape($id_vehiculo);
        $this->db->where('id_vehiculo', $id_vehiculo);
        $this->db->delete('vehiculos');
    }

    /**
     * Retorna si existen llaves foráneas respecto a un vehiculo
     * @param int $id_vehiculo
     * @return boolean $existe true si sí existen llaves foráneas (fk)
     */
    function existe_llaves_foraneas_vehiculo($id_vehiculo) {
        $this->db->escape($id_vehiculo);
        $this->db->where('id_vehiculo', $id_vehiculo);
        $query = $this->db->get('autopartes_vehiculos');
        if ($query->num_rows() != 0)
            return TRUE;
        else {
            $this->db->flush_cache();
            $this->db->where('id_vehiculo', $id_vehiculo);
            $query = $this->db->get('usuarios_vehiculos');
            if ($query->num_rows() != 0)
                return TRUE;
            return FALSE;
        }
    }

    /**
     * Da la hoja de mantenimiento según el id_vehiculo(no incluye soat o tecnicomecanica)
     * @param type $id_vehiculo
     * @return type
     */
    function dar_hoja_mantenimiento($id_vehiculo) {
//        $q = $this->db->query('SELECT  p.nombre, o.periodicidad, p.id_servicio
//                                FROM    tareas p
//                                JOIN
//                                        tareas_servicios o
//                                ON      o.id_servicio = p.id_servicio where o.id_vehiculo = '.$id_vehiculo.' and o.id_servicio != 9 and o.id_servicio != 10
//                                union all
//                                SELECT  p.nombre, NULL, p.id_servicio
//                                FROM    tareas p
//                                WHERE   p.id_servicio NOT IN
//                                        (
//                                        SELECT  ts.id_servicio
//                                        FROM    tareas_servicios ts
//                                                where ts.id_vehiculo = '.$id_vehiculo.'
//                                        ) and p.id_servicio != 9 and p.id_servicio != 10');
        $this->db->select('tareas.nombre, tareas_servicios.periodicidad, tareas_servicios.rango, tareas_servicios.modelo, tareas_servicios.id_servicio, tareas_servicios.id_tarea');
        $this->db->from('tareas');
        $this->db->join('tareas_servicios', 'tareas_servicios.id_servicio = tareas.id_servicio');
        $this->db->where('tareas_servicios.id_vehiculo', $id_vehiculo);
        $this->db->order_by('tareas_servicios.modelo', 'desc');
        $this->db->order_by('tareas.nombre');
        $q = $this->db->get();
        return $q->result();
    }

    /**
     * Agrega/actualiza una tarea a la hoja de mantenimiento para el vehículo
     * @param type $id_vehiculo
     * @param type $id_tarea
     * @param type $periodicidad
     * @param type $otro
     */
    function agregar_tarea_hoja_mto($id_vehiculo, $id_servicio, $periodicidad, $rango, $modelo, $otro, $textAreaOtro, $imagen_url, $id_tarea) {
        $this->db->escape($id_vehiculo);
        $this->db->escape($id_tarea);
        $this->db->escape($id_servicio);
        $this->db->escape($periodicidad);
        $this->db->escape($rango);
        $this->db->escape($modelo);
        $this->db->escape($otro);
        $this->db->escape($textAreaOtro);
        $this->db->escape($imagen_url);
        $this->db->where('id_tarea', $id_tarea);
        $this->db->where('id_servicio', $id_servicio);
        $this->db->where('id_vehiculo', $id_vehiculo);
        $q = $this->db->get('tareas_servicios');
        if ($q->num_rows() > 0) {
            $this->db->where('id_tarea', $id_tarea);
            $this->db->set('id_servicio', $id_servicio);
            $this->db->set('periodicidad', $periodicidad);
            $this->db->set('rango', $rango);
            $this->db->set('modelo', $modelo);
            $this->db->update('tareas_servicios');
        } else {
            if ($id_servicio != 0) {
                $this->db->set('id_servicio', $id_servicio);
                $this->db->set('id_vehiculo', $id_vehiculo);
                $this->db->set('periodicidad', $periodicidad);
                $this->db->set('rango', $rango);
                $this->db->set('modelo', $modelo);
                $this->db->insert('tareas_servicios');
            } else {
                $this->db->set('nombre', $otro);
                $this->db->set('descripcion', $textAreaOtro);
                $this->db->set('imagen_thumb_url', $imagen_url);
                $this->db->insert('tareas');
                
                $id_insertado = mysql_insert_id();
                $this->db->set('id_servicio', $id_insertado);
                if ($id_tarea) {
                    $this->db->set('periodicidad', $periodicidad);
                    $this->db->set('rango', $rango);
                    $this->db->set('modelo', $modelo);
                    $this->db->where('id_tarea', $id_tarea);
                    $this->db->update('tareas_servicios'); 
                } else {
                    $this->db->set('id_vehiculo', $id_vehiculo);
                    $this->db->set('periodicidad', $periodicidad);
                    $this->db->set('rango', $rango);
                    $this->db->set('modelo', $modelo);
                    $this->db->insert('tareas_servicios');
                }
            }
        }
    }

    function eliminar_tarea_hoja_mto($id_tarea) {
        $this->db->escape($id_tarea);
        $this->db->where('id_tarea', $id_tarea);
        $this->db->delete('tareas_servicios');
    }

}