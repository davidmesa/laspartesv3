<?php

/**
 * Clase que maneja la BD en donde las consultas se concentra en las tablas
 * noticias, noticias_comentarios, noticias_me_gustan
 */
class Noticia_model extends CI_Model{

    /**
     * Constructor de la clase Noticia_model
     */
    function __construct(){
        parent::__construct();
    }

    /**
     * Actualiza una noticia
     * @param int $id_noticia
     * @param String $titulo
     * @param String $noticia
     * @param String $estado
     */
    function actualizar_noticia($id_noticia, $titulo, $noticia, $estado){
        $this->db->escape($id_noticia);
        $this->db->escape($titulo);
        $this->db->escape($noticia);
        $this->db->escape($estado);
        $this->db->set('titulo', $titulo);
        $this->db->set('noticia', $noticia);
        $this->db->set('estado', $estado);
        $this->db->where('id_noticia', $id_noticia);
        $this->db->update('noticias');
    }

    /**
     * Agrega un nuevo comentario a una noticia
     * @param int $id_noticia
     * @param int $id_usuario
     * @param String $comentario
     * @return int $id_noticia_comentario
     */
    function agregar_noticia_comentario($id_noticia, $id_usuario, $comentario){
        $this->db->escape($id_noticia);
        $this->db->escape($comentario);
        $this->db->set('id_noticia', $id_noticia);
        $this->db->set('id_usuario', $id_usuario);
        $this->db->set('comentario', $comentario);
        $this->db->set('fecha', 'now()', FALSE);
        $this->db->insert('noticias_comentarios');
        return mysql_insert_id();
    }

    /**
     * Actualiza la imagen de una noticia
     * @param int $id_noticia
     * @param String $imagen_url
     * @param String $imagen_thumb_url
     */
    function actualizar_noticia_imagen_url($id_noticia, $imagen_url, $imagen_thumb_url){
        $this->db->escape($id_noticia);
        $this->db->escape($imagen_url);
        $this->db->escape($imagen_thumb_url);
        $this->db->set('imagen_url', $imagen_url);
        $this->db->set('imagen_thumb_url', $imagen_thumb_url);
        $this->db->where('id_noticia', $id_noticia);
        $this->db->update('noticias');
    }

    /**
     * Actualiza el campo me_gusta de una noticia
     * @param int $id_noticia
     */
    function actualizar_noticia_me_gusta($id_noticia){
        $this->db->escape($id_noticia);
        $this->db->set('me_gusta', 'me_gusta+1', FALSE);
        $this->db->where('id_noticia', $id_noticia);
        $this->db->limit(1);
        $this->db->update('noticias');
    }

    /**
     * Actualiza el campo no_me_gusta de una noticia
     * @param int $id_noticia
     */
    function actualizar_noticia_no_me_gusta($id_noticia){
        $this->db->escape($id_noticia);
        $this->db->set('no_me_gusta', 'no_me_gusta+1', FALSE);
        $this->db->where('id_noticia', $id_noticia);
        $this->db->limit(1);
        $this->db->update('noticias');
    }

    /**
     * Actualiza en número de visitas de una noticia
     * @param int $id_noticia
     */
    function actualizar_numero_visitas($id_noticia){
        $this->db->escape($id_noticia);
        $this->db->set('numero_visitas', 'numero_visitas+1', FALSE);
        $this->db->where('id_noticia', $id_noticia);
        $this->db->limit(1);
        $this->db->update('noticias');
    }

    /**
     * Agrega una nueva noticia
     * @param String $titulo
     * @param String $noticia
     * @param String $estado
     * @return int $id_noticia
     */
    function agregar_noticia($titulo, $noticia, $estado){
        $this->db->escape($titulo);
        $this->db->escape($noticia);
        $this->db->escape($estado);
        $this->db->set('titulo', $titulo);
        $this->db->set('noticia', $noticia);
        $this->db->set('estado', $estado);
        $this->db->set('fecha', 'curdate()', FALSE);
        $this->db->insert('noticias');
        return mysql_insert_id();
    }

    /**
     * Agrega un nuevo me gusta
     * @param int $id_usuario
     * @param int $id_noticia
     * @param bool $me_gusta
     */
    function agregar_me_gusta($id_usuario, $id_noticia, $me_gusta){
        $this->db->escape($id_usuario);
        $this->db->escape($id_noticia);
        $this->db->escape($me_gusta);
        $this->db->set('id_usuario', $id_usuario);
        $this->db->set('id_noticia', $id_noticia);
        $this->db->set('me_gusta', $me_gusta);
        $this->db->insert('noticias_me_gustan');
    }

    /**
     * Da el número de noticias activas
     * @return int $numero_noticias
     */
    function contar_noticias(){
        $this->db->where('estado', 'Activo');
        $query = $this->db->get('noticias');
        return $query->num_rows();
    }

    /**
     * Da una noticia
     * @param int $id_noticia
     * @return object $noticia
     */
    function dar_noticia($id_noticia){
        $this->db->escape($id_noticia);
        $this->db->where('id_noticia', $id_noticia);
        $query = $this->db->get('noticias');
        return $query->row(0);
    }

    /**
     * Da los comentarios de una noticia
     * @param int $id_noticia
     * @return array $noticia_comentarios
     */
    function dar_noticia_comentarios($id_noticia){
        $this->db->escape($id_noticia);
        $this->db->select('id_noticia_comentario, noticias_comentarios.id_usuario, fecha, comentario, usuario, imagen_thumb_url');
        $this->db->join('usuarios', 'usuarios.id_usuario = noticias_comentarios.id_usuario');
        $this->db->where('id_noticia', $id_noticia);
        $query = $this->db->get('noticias_comentarios');
        return $query->result();
    }

    /**
     * Da la lista de noticias de acuerdo a la paginación y ordenamiento
     * @param int $limit
     * @param int $offset
     * @param String $orden
     * @return array $noticias
     */
    function dar_noticias_paginacion_filtros($limit, $offset, $orden){
        $this->db->escape($limit);
        $this->db->escape($offset);
        $this->db->escape($orden);
        if($orden=='visitas')
            $this->db->order_by('numero_visitas', 'desc');
        else
            $this->db->order_by('fecha', 'desc');
        $this->db->where('estado', 'Activo');
        $this->db->limit($limit, $offset);
        $query = $this->db->get('noticias');
        return $query->result();
    }

    /**
     * Da la información si a un usuario le gusta o no o no ha decidido acerca de una noticia
     * @param int $id_noticia
     * @param int $id_usuario
     * @return bool $me_gusta true (1) si le gusta, false (0) si no le gusta, NULL si no ha decidido
     */
    function dar_noticia_le_gusta_usuario($id_noticia, $id_usuario){
        $this->db->escape($id_usuario);
        $this->db->escape($id_noticia);
        $this->db->select('me_gusta');
        $this->db->where('id_noticia', $id_noticia);
        $this->db->where('id_usuario', $id_usuario);
        $query = $this->db->get('noticias_me_gustan');
        if($query->num_rows()==0)
            return NULL;
        else
            return $query->row(0)->me_gusta;
    }

    /**
     * Da la lista de noticias
     * @return array $noticias
     */
    function dar_noticias(){
        $query = $this->db->get('noticias');
        return $query->result();
    }
    
    /**
     * Da la lista de noticias
     * @return array $noticias
     */
    function dar_noticias_offset($offset){
        $this->db->escape($offset);
        $this->db->limit(3, $offset);
        $this->db->order_by('fecha', desc);
        $query = $this->db->get('noticias');
        return $query->result();
    }

    /**
     * Da las noticias donde ha comentado un usuario
     * @param int $id_usuario
     * @return array $noticias
     */
    function dar_noticias_comentarios_usuario($id_usuario){
        $this->db->escape($id_usuario);
        $this->db->select('noticias.id_noticia, titulo, noticia, imagen_thumb_url, noticias.fecha');
        $this->db->distinct();
        $this->db->join('noticias_comentarios', 'noticias_comentarios.id_noticia = noticias.id_noticia');
        $this->db->where('id_usuario', $id_usuario);
        $query = $this->db->get('noticias');
        return $query->result();
    }

    /**
     * Da las últimas 3 noticias registradas
     * @param int $limit Número de resultados
     * @return array $noticias
     */
    function dar_noticias_ultimas($limit, $id_noticia){
        $this->db->where('estado', 'Activo');
        if($id_noticia != '')
            $this->db->where('id_noticia != ', $id_noticia);
        $this->db->order_by('fecha', 'desc');
        $this->db->limit($limit);
        $query = $this->db->get('noticias');
        return $query->result();
    }
    
     function dar_numNoticias(){
        $query = $this->db->get('noticias');
        return $query->num_rows(); 
    }

    /**
     * Elimina un comentario de una noticia
     * @param int $id_noticia_comentario
     */
    function eliminar_noticia_comentario($id_noticia_comentario){
        $this->db->escape($id_noticia_comentario);
        $this->db->where('id_noticia_comentario', $id_noticia_comentario);
        $this->db->delete('noticias_comentarios');
    }

    /**
     * Elimina la imagen de una noticia
     * @param int $id_noticia
     */
    function eliminar_noticia_imagen($id_noticia){
        $this->db->escape($id_noticia);
        $this->db->set('imagen_url', NULL);
        $this->db->set('imagen_thumb_url', NULL);
        $this->db->where('id_noticia', $id_noticia);
        $this->db->update('noticias');
    }
}