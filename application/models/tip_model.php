<?php

/**
 * Clase que maneja la BD en donde las consultas se concentra en las tablas
 * tips, tips_comentarios, tips_me_gustan
 */
class Tip_model extends CI_Model{

    /**
     * Constructor de la clase Tip_model
     */
    function __construct(){
        parent::__construct();
    }

    /**
     * Actualiza en número de visitas de un tip
     * @param int $id_tip
     */
    function actualizar_numero_visitas($id_tip){
        $this->db->escape($id_tip);
        $this->db->set('numero_visitas', 'numero_visitas+1', FALSE);
        $this->db->where('id_tip', $id_tip);
        $this->db->limit(1);
        $this->db->update('tips');
    }

    /**
     * Actualiza un tip
     * @param int $id_tip
     * @param String $titulo
     * @param String $tip
     * @param String $estado
     */
    function actualizar_tip($id_tip, $titulo, $tip, $estado){
        $this->db->escape($id_tip);
        $this->db->escape($titulo);
        $this->db->escape($tip);
        $this->db->escape($estado);
        $this->db->set('titulo', $titulo);
        $this->db->set('tip', $tip);
        $this->db->set('estado', $estado);
        $this->db->where('id_tip', $id_tip);
        $this->db->update('tips');

    }

    /**
     * Actualiza la imagen de un tip
     * @param int $id_tip
     * @param String $imagen_url
     * @param String $imagen_thumb_url
     */
    function actualizar_tip_imagen_url($id_tip, $imagen_url, $imagen_thumb_url){
        $this->db->escape($id_tip);
        $this->db->escape($imagen_url);
        $this->db->escape($imagen_thumb_url);
        $this->db->set('imagen_url', $imagen_url);
        $this->db->set('imagen_thumb_url', $imagen_thumb_url);
        $this->db->where('id_tip', $id_tip);
        $this->db->update('tips');
    }

    /**
     * Agrega un nuevo me gusta
     * @param int $id_usuario
     * @param int $id_tip
     * @param bool $me_gusta
     */
    function agregar_me_gusta($id_usuario, $id_tip, $me_gusta){
        $this->db->escape($id_usuario);
        $this->db->escape($id_tip);
        $this->db->escape($me_gusta);
        $this->db->set('id_usuario', $id_usuario);
        $this->db->set('id_tip', $id_tip);
        $this->db->set('me_gusta', $me_gusta);
        $this->db->insert('tips_me_gustan');
    }

    /**
     * Agrega un nuevo tip
     * @param String $titulo
     * @param String $tip
     * @param String $estado
     * @return int $id_tip
     */
    function agregar_tip($titulo, $tip, $estado){
        $this->db->escape($titulo);
        $this->db->escape($tip);
        $this->db->escape($estado);
        $this->db->set('titulo', $titulo);
        $this->db->set('tip', $tip);
        $this->db->set('estado', $estado);
        $this->db->set('fecha', 'now()', FALSE);
        $this->db->insert('tips');
        return mysql_insert_id();
    }

    /**
     * Agrega un nuevo comentario a un tip
     * @param int $id_tip
     * @param int $id_usuario
     * @param String $comentario
     * @return int $id_tip_comentario
     */
    function agregar_tip_comentario($id_tip, $id_usuario, $comentario){
        $this->db->escape($id_tip);
        $this->db->escape($comentario);
        $this->db->set('id_tip', $id_tip);
        $this->db->set('id_usuario', $id_usuario);
        $this->db->set('comentario', $comentario);
        $this->db->set('fecha', 'now()', FALSE);
        $this->db->insert('tips_comentarios');
        return mysql_insert_id();
    }

    /**
     * Da el número de tips activas
     * @return int $numero_tips
     */
    function contar_tips(){
        $this->db->where('estado', 'Activo');
        $query = $this->db->get('tips');
        return $query->num_rows();
    }

    /**
     * Da un tip
     * @param int $id_tip
     * @return object $tip
     */
    function dar_tip($id_tip){
        $this->db->escape($id_tip);
        $this->db->where('id_tip', $id_tip);
        $query = $this->db->get('tips');
        return $query->row(0);
    }

    /**
     * Actualiza el campo me_gusta de un tip
     * @param int $id_tip
     */
    function actualizar_tip_me_gusta($id_tip){
        $this->db->escape($id_tip);
        $this->db->set('me_gusta', 'me_gusta+1', FALSE);
        $this->db->where('id_tip', $id_tip);
        $this->db->limit(1);
        $this->db->update('tips');
    }

    /**
     * Actualiza el campo no_me_gusta de un tip
     * @param int $id_tip
     */
    function actualizar_tip_no_me_gusta($id_tip){
        $this->db->escape($id_tip);
        $this->db->set('no_me_gusta', 'no_me_gusta+1', FALSE);
        $this->db->where('id_tip', $id_tip);
        $this->db->limit(1);
        $this->db->update('tips');
    }

    /**
     * Da los comentarios de un tip
     * @param int $id_tip
     * @return array $tips_comentarios
     */
    function dar_tip_comentarios($id_tip){
        $this->db->escape($id_tip);
        $this->db->select('id_tip_comentario, tips_comentarios.id_usuario, fecha, comentario, usuario, imagen_thumb_url');
        $this->db->join('usuarios', 'usuarios.id_usuario = tips_comentarios.id_usuario');
        $this->db->where('id_tip', $id_tip);
        $query = $this->db->get('tips_comentarios');
        return $query->result();
    }

    /**
     * Da los tips donde ha comentado un usuario
     * @param int $id_usuario
     * @return array $tips
     */
    function dar_tips_comentarios_usuario($id_usuario){
        $this->db->escape($id_usuario);
        $this->db->select('tips.id_tip, titulo, tip, imagen_thumb_url, tips.fecha');
        $this->db->distinct();
        $this->db->join('tips_comentarios', 'tips_comentarios.id_tip = tips.id_tip');
        $this->db->where('id_usuario', $id_usuario);
        $query = $this->db->get('tips');
        return $query->result();
    }

    /**
     * Da la lista de tips de acuerdo a la paginación y ordenamiento
     * @param int $limit
     * @param int $offset
     * @param String $orden
     * @return array $tips
     */
    function dar_tips_paginacion_filtros($limit, $offset, $orden){
        $this->db->escape($limit);
        $this->db->escape($offset);
        $this->db->escape($orden);
        if($orden=='visitas')
            $this->db->order_by('numero_visitas', 'desc');
        else
            $this->db->order_by('fecha', 'desc');
        $this->db->where('estado', 'Activo');
        $this->db->limit($limit, $offset);
        $query = $this->db->get('tips');
        return $query->result();
    }

    /**
     * Da la información si a un usuario le gusta o no o no ha decidido acerca de un tip
     * @param int $id_tip
     * @param int $id_usuario
     * @return bool $me_gusta true (1) si le gusta, false (0) si no le gusta, NULL si no ha decidido
     */
    function dar_tip_le_gusta_usuario($id_tip, $id_usuario){
        $this->db->escape($id_usuario);
        $this->db->escape($id_tip);
        $this->db->select('me_gusta');
        $this->db->where('id_tip', $id_tip);
        $this->db->where('id_usuario', $id_usuario);
        $query = $this->db->get('tips_me_gustan');
        if($query->num_rows()==0)
            return NULL;
        else
            return $query->row(0)->me_gusta;
    }

    /**
     * Da la lista de tips
     * @return array $tips
     */
    function dar_tips(){
        $query = $this->db->get('tips');
        return $query->result();
    }
    
    function dar_numTips(){
         $query = $this->db->get('tips');
        return $query->num_rows(); 
    }

    /**
     * Da los 5 últimos tips
     * @param int $limit Número de tips
     * @return array $tips
     */
    function dar_tips_ultimos($limit, $id_tip){
        if($id_tip != '')
            $this->db->where('id_tip != ', $id_tip);
        $this->db->where('estado', 'Activo');
        $this->db->order_by('fecha', 'desc');
        $this->db->limit($limit);
        $query = $this->db->get('tips');
        return $query->result();
    }

    /**
     * Elimina un comentario de un tip
     * @param int $id_tip_comentario
     */
    function eliminar_tip_comentario($id_tip_comentario){
        $this->db->escape($id_tip_comentario);
        $this->db->where('id_tip_comentario', $id_tip_comentario);
        $this->db->delete('tips_comentarios');
    }

    /**
     * Elimina la imagen de un tip
     * @param int $id_tip
     */
    function eliminar_tip_imagen($id_tip){
        $this->db->escape($id_tip);
        $this->db->set('imagen_url', NULL);
        $this->db->set('imagen_thumb_url', NULL);
        $this->db->where('id_tip', $id_tip);
        $this->db->update('tips');
    }
    
    /**
     * Da la lista de noticias
     * @return array $noticias
     */
    function dar_tips_offset($offset){
        $this->db->escape($offset);
        $this->db->limit(5, $offset);
        $this->db->order_by('fecha', desc);
        $query = $this->db->get('tips');
        return $query->result();
    }
}