<?php

/**
 * Clase que maneja la BD en donde las consultas se concentra en las tablas
 * tutoriales, tutoriales_pasos, tutoriales_comentarios, tutoriales_me_gustan
 */
class Tutorial_model extends CI_Model{

    /**
     * Constructor de la clase Tutorial_model
     */
    function __construct(){
        parent::__construct();
    }

    /**
     * Actualiza en número de visitas de un tutorial
     * @param int $id_tutorial
     */
    function actualizar_numero_visitas($id_tutorial){
        $this->db->escape($id_tutorial);
        $this->db->set('numero_visitas', 'numero_visitas+1', FALSE);
        $this->db->where('id_tutorial', $id_tutorial);
        $this->db->limit(1);
        $this->db->update('tutoriales');
    }

    /**
     * Actualiza un tutorial
     * @param int $id_tutorial
     * @param String $titulo
     * @param String $resumen
     * @param String $estado
     */
    function actualizar_tutorial($id_tutorial, $titulo, $resumen, $estado){
        $this->db->escape($id_tutorial);
        $this->db->escape($titulo);
        $this->db->escape($resumen);
        $this->db->escape($estado);
        $this->db->set('titulo', $titulo);
        $this->db->set('resumen', $resumen);
        $this->db->set('estado', $estado);
        $this->db->where('id_tutorial', $id_tutorial);
        $this->db->update('tutoriales');
    }

    /**
     * Actualiza la imagen de un tutorial
     * @param int $id_tutorial
     * @param String $imagen_url
     * @param String $imagen_thumb_url
     */
    function actualizar_tutorial_imagen_url($id_tutorial, $imagen_url, $imagen_thumb_url){
        $this->db->escape($id_tutorial);
        $this->db->escape($imagen_url);
        $this->db->escape($imagen_thumb_url);
        $this->db->set('imagen_url', $imagen_url);
        $this->db->set('imagen_thumb_url', $imagen_thumb_url);
        $this->db->where('id_tutorial', $id_tutorial);
        $this->db->update('tutoriales');

    }

    /**
     * Actualiza un paso de un tutorial
     * @param int $id_tutorial_paso
     * @param String $paso
     */
    function actualizar_tutorial_paso($id_tutorial_paso, $paso){
        $this->db->escape($id_tutorial_paso);
        $this->db->escape($paso);
        $this->db->set('paso', $paso);
        $this->db->where('id_tutorial_paso', $id_tutorial_paso);
        $this->db->update('tutoriales_pasos');
    }

    /**
     * Actualiza la imagen de un paso de un tutorial
     * @param int $id_tutorial
     * @param String $imagen_url
     */
    function actualizar_tutorial_paso_imagen_url($id_tutorial_paso, $imagen_url){
        $this->db->escape($id_tutorial_paso);
        $this->db->escape($imagen_url);
        $this->db->set('imagen_url', $imagen_url);
        $this->db->where('id_tutorial_paso', $id_tutorial_paso);
        $this->db->update('tutoriales_pasos');
    }

    /**
     * Agrega un nuevo me gusta
     * @param int $id_usuario
     * @param int $id_tutorial
     * @param bool $me_gusta
     */
    function agregar_me_gusta($id_usuario, $id_tutorial, $me_gusta){
        $this->db->escape($id_usuario);
        $this->db->escape($id_tutorial);
        $this->db->escape($me_gusta);
        $this->db->set('id_usuario', $id_usuario);
        $this->db->set('id_tutorial', $id_tutorial);
        $this->db->set('me_gusta', $me_gusta);
        $this->db->insert('tutoriales_me_gustan');
    }

    /**
     * Agrega un nuevo tutorial
     * @param String $titulo
     * @param String $resumen
     * @param String $estado
     * @return int $id_tutorial
     */
    function agregar_tutorial($titulo, $resumen, $estado){
        $this->db->escape($titulo);
        $this->db->escape($resumen);
        $this->db->escape($estado);
        $this->db->set('titulo', $titulo);
        $this->db->set('resumen', $resumen);
        $this->db->set('estado', $estado);
        $this->db->set('fecha', 'curdate()', FALSE);
        $this->db->insert('tutoriales');
        return mysql_insert_id();
    }

    /**
     * Agrega un nuevo comentario a un tutorial
     * @param int $id_tutorial
     * @param int $id_usuario
     * @param String $comentario
     * @return int $id_tutorial_comentario
     */
    function agregar_tutorial_comentario($id_tutorial, $id_usuario, $comentario){
        $this->db->escape($id_tutorial);
        $this->db->escape($comentario);
        $this->db->set('id_tutorial', $id_tutorial);
        $this->db->set('id_usuario', $id_usuario);
        $this->db->set('comentario', $comentario);
        $this->db->set('fecha', 'now()', FALSE);
        $this->db->insert('tutoriales_comentarios');
        return mysql_insert_id();
    }

    /**
     * Agrega un nuevo paso a un tutorial
     * @param int $id_tutorial
     * @param String $paso
     * @return int $id_tutorial_paso
     */
    function agregar_tutorial_paso($id_tutorial, $paso){
        $this->db->escape($id_tutorial);
        $this->db->escape($paso);
        $this->db->set('id_tutorial', $id_tutorial);
        $this->db->set('paso', $paso);
        $this->db->insert('tutoriales_pasos');
        return mysql_insert_id();
    }

    /**
     * Actualiza el campo me_gusta de un tutorial
     * @param int $id_tutorial
     */
    function actualizar_tutorial_me_gusta($id_tutorial){
        $this->db->escape($id_tutorial);
        $this->db->set('me_gusta', 'me_gusta+1', FALSE);
        $this->db->where('id_tutorial', $id_tutorial);
        $this->db->limit(1);
        $this->db->update('tutoriales');
    }

    /**
     * Actualiza el campo no_me_gusta de un tutorial
     * @param int $id_tutorial
     */
    function actualizar_tutorial_no_me_gusta($id_tutorial){
        $this->db->escape($id_tutorial);
        $this->db->set('no_me_gusta', 'no_me_gusta+1', FALSE);
        $this->db->where('id_tutorial', $id_tutorial);
        $this->db->limit(1);
        $this->db->update('tutoriales');
    }

    /**
     * Da el número de tutoriales activas
     * @return int $numero_tutoriales
     */
    function contar_tutoriales(){
        $this->db->where('estado', 'Activo');
        $query = $this->db->get('tutoriales');
        return $query->num_rows();
    }

    /**
     * Da un tutorial
     * @param int $id_tutorial
     * @return object $tutorial
     */
    function dar_tutorial($id_tutorial){
        $this->db->escape($id_tutorial);
        $this->db->where('id_tutorial', $id_tutorial);
        $query = $this->db->get('tutoriales');
        return $query->row(0);
    }

    /**
     * Da un paso de un tutorial
     * @param int $id_tutorial_paso
     * @return object $tutorial_paso
     */
    function dar_tutorial_paso($id_tutorial_paso){
        $this->db->escape($id_tutorial_paso);
        $this->db->where('id_tutorial_paso', $id_tutorial_paso);
        $query = $this->db->get('tutoriales_pasos');
        return $query->row(0);
    }

    /**
     * Da los pasos de un tutorial
     * @param int $id_tutorial
     * @return array $tutorial_pasos
     */
    function dar_tutorial_pasos($id_tutorial){
        $this->db->escape($id_tutorial);
        $this->db->where('id_tutorial', $id_tutorial);
        $this->db->order_by('id_tutorial_paso', 'asc');
        $query = $this->db->get('tutoriales_pasos');
        return $query->result();
    }

    /**
     * Da los comentarios de un tutorial
     * @param int $id_tutorial
     * @return array $tutorial_comentarios
     */
    function dar_tutorial_comentarios($id_tutorial){
        $this->db->escape($id_tutorial);
        $this->db->select('id_tutorial_comentario, tutoriales_comentarios.id_usuario, fecha, comentario, usuario, imagen_thumb_url');
        $this->db->join('usuarios', 'usuarios.id_usuario = tutoriales_comentarios.id_usuario');
        $this->db->where('id_tutorial', $id_tutorial);
        $query = $this->db->get('tutoriales_comentarios');
        return $query->result();
    }

    /**
     * Da los tutoriales donde ha comentado un usuario
     * @param int $id_usuario
     * @return array $tutoriales
     */
    function dar_tutoriales_comentarios_usuario($id_usuario){
        $this->db->escape($id_usuario);
        $this->db->select('tutoriales.id_tutorial, titulo, resumen, imagen_thumb_url, tutoriales.fecha');
        $this->db->distinct();
        $this->db->join('tutoriales_comentarios', 'tutoriales_comentarios.id_tutorial = tutoriales.id_tutorial');
        $this->db->where('id_usuario', $id_usuario);
        $query = $this->db->get('tutoriales');
        return $query->result();
    }

    /**
     * Da la lista de tutoriales de acuerdo a la paginación y ordenamiento
     * @param int $limit
     * @param int $offset
     * @param String $orden
     * @return array $tutoriales
     */
    function dar_tutoriales_paginacion_filtros($limit, $offset, $orden){
        $this->db->escape($limit);
        $this->db->escape($offset);
        $this->db->escape($orden);
        if($orden=='visitas')
            $this->db->order_by('numero_visitas', 'desc');
        else
            $this->db->order_by('fecha', 'desc');
        $this->db->where('estado', 'Activo');
        $this->db->limit($limit, $offset);
        $query = $this->db->get('tutoriales');
        return $query->result();
    }

    /**
     * Da la información si a un usuario le gusta o no o no ha decidido acerca de un tutorial
     * @param int $id_tutorial
     * @param int $id_usuario
     * @return bool $me_gusta true (1) si le gusta, false (0) si no le gusta, NULL si no ha decidido
     */
    function dar_tutorial_le_gusta_usuario($id_tutorial, $id_usuario){
        $this->db->escape($id_usuario);
        $this->db->escape($id_tutorial);
        $this->db->select('me_gusta');
        $this->db->where('id_tutorial', $id_tutorial);
        $this->db->where('id_usuario', $id_usuario);
        $query = $this->db->get('tutoriales_me_gustan');
        if($query->num_rows()==0)
            return NULL;
        else
            return $query->row(0)->me_gusta;
    }

    /**
     * Da la lista de tutoriales
     * @return array $tutoriales
     */
    function dar_tutoriales(){
        $query = $this->db->get('tutoriales');
        return $query->result();
    }

    /**
     * Da los últimos 2 tutoriales
     * @param $limit Número de resultados
     * @return array $tutoriales
     */
    function dar_tutoriales_ultimos($limit){
        $this->db->where('estado', 'Activo');
        $this->db->order_by('fecha', 'desc');
        $this->db->limit($limit);
        $query = $this->db->get('tutoriales');
        return $query->result();
    }

    /**
     * Elimina un comentario de un tutorial
     * @param int $id_tutorial_comentario
     */
    function eliminar_tutorial_comentario($id_tutorial_comentario){
        $this->db->escape($id_tutorial_comentario);
        $this->db->where('id_tutorial_comentario', $id_tutorial_comentario);
        $this->db->delete('tutoriales_comentarios');
    }

    /**
     * Elimina la url de la imagen de un tutorial
     * @param int $id_tutorial
     */
    function eliminar_tutorial_imagen($id_tutorial){
        $this->db->escape($id_tutorial);
        $this->db->set('imagen_url', NULL);
        $this->db->set('imagen_thumb_url', NULL);
        $this->db->where('id_tutorial', $id_tutorial);
        $this->db->update('tutoriales');
    }

    /**
     * Elimina la url de la imagen de un paso de un tutorial
     * @param int $id_tutorial_paso
     */
    function eliminar_tutorial_paso_imagen($id_tutorial_paso){
        $this->db->escape($id_tutorial_paso);
        $this->db->set('imagen_url', NULL);
        $this->db->where('id_tutorial_paso', $id_tutorial_paso);
        $this->db->update('tutoriales_pasos');
    }

    /**
     * Elimina un paso de un tutorial
     * @param int $id_tutorial_paso
     */
    function eliminar_tutorial_paso($id_tutorial_paso){
        $this->db->escape($id_tutorial_paso);
        $this->db->where('id_tutorial_paso', $id_tutorial_paso);
        $this->db->delete('tutoriales_pasos');
    }
}